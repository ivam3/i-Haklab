#!/usr/bin/env python3
import os
import re

def patch_cargo_toml():
    path = "Cargo.toml"
    if not os.path.exists(path):
        return

    with open(path, "r") as f:
        content = f.read()

    if 'target_os = "android"' in content:
        print("Cargo.toml already patched.")
    else:
        print("Patching Cargo.toml...")
        # Remove old arboard dependency
        content = re.sub(r'# Clipboard support\s+arboard = "3.4"\s+', '', content)
        
        # Add target-specific dependency before [profile.release]
        new_block = '# Clipboard support\n[target.\'cfg(not(any(target_os = "android", target_os = "ios")))\'.dependencies]\narboard = "3.4"\n\n[profile.release]'
        content = content.replace('[profile.release]', new_block)
        
        # Fix quote type in search regex for consistency
        content = content.replace('search = "## [Unreleased]"', "search = '## [Unreleased]'")

    with open(path, "w") as f:
        f.write(content)

def patch_tui_rs():
    path = "src/tui.rs"
    if not os.path.exists(path):
        return

    with open(path, "r") as f:
        content = f.read()

    if "fn set_clipboard" in content:
        print("src/tui.rs already patched.")
        return

    print("Patching src/tui.rs...")
    
    # 1. Patch imports
    content = content.replace(
        "use arboard::Clipboard;",
        '#[cfg(not(any(target_os = "android", target_os = "ios")))]\nuse arboard::Clipboard;'
    )

    # 2. Add set_clipboard method
    marker = "Some((col - 1, row - 1)) // Convert to 0-indexed\n    }"
    set_clipboard_impl = r'''
    /// Set clipboard content with platform-specific handling
    fn set_clipboard(&mut self, text: String, success_msg: String) {
        #[cfg(not(any(target_os = "android", target_os = "ios")))]
        {
            match Clipboard::new() {
                Ok(mut clipboard) => {
                    if let Err(e) = clipboard.set_text(&text) {
                        self.copy_feedback = Some((format!("Copy failed: {}" , e), Instant::now()));
                    } else {
                        self.copy_feedback = Some((success_msg, Instant::now()));
                    }
                }
                Err(e) => {
                    self.copy_feedback = Some((format!("Clipboard error: {}" , e), Instant::now()));
                }
            }
        }
        #[cfg(target_os = "android")]
        {
            // Try to use termux-clipboard-set if available
            use std::io::Write;
            let child = std::process::Command::new("termux-clipboard-set")
                .stdin(std::process::Stdio::piped())
                .spawn();

            match child {
                Ok(mut child) => {
                    let mut success = false;
                    if let Some(mut stdin) = child.stdin.take() {
                        if stdin.write_all(text.as_bytes()).is_ok() {
                            success = true;
                        }
                    }
                    if success && child.wait().map(|s| s.success()).unwrap_or(false) {
                        self.copy_feedback = Some((success_msg, Instant::now()));
                    } else {
                        self.copy_feedback = Some((
                            "Copy failed (is termux-api installed?)".to_string(),
                            Instant::now(),
                        ));
                    }
                }
                Err(_) => {
                    self.copy_feedback = Some((
                        "Copy failed (termux-clipboard-set not found)".to_string(),
                        Instant::now(),
                    ));
                }
            }
        }
        #[cfg(target_os = "ios")]
        {
            let _ = text;
            self.copy_feedback = Some(("Copy not supported on iOS".to_string(), Instant::now()));
        }
    }
'''

    content = content.replace(marker, marker + set_clipboard_impl)

    # 3. Update copy_current_cell
    old_copy_cell = r'''    /// Copy the current cell value to clipboard
    fn copy_current_cell(&mut self) {
        let (cell, _formula) = self.sheet_data.get_cell(self.cursor_row, self.cursor_col);
        let cell_value = cell.map(|v| v.to_raw_string()).unwrap_or_default();

        match Clipboard::new() {
            Ok(mut clipboard) => {
                if let Err(e) = clipboard.set_text(&cell_value) {
                    self.copy_feedback = Some((format!("Copy failed: {}", e), Instant::now()));
                } else {
                    let cell_addr = self.current_cell_address();
                    self.copy_feedback =
                        Some((format!("Copied cell {}", cell_addr), Instant::now()));
                }
            }
            Err(e) => {
                self.copy_feedback = Some((format!("Clipboard error: {}", e), Instant::now()));
            }
        }
    }'''

    new_copy_cell = r'''    /// Copy the current cell value to clipboard
    fn copy_current_cell(&mut self) {
        let (cell, _formula) = self.sheet_data.get_cell(self.cursor_row, self.cursor_col);
        let cell_value = cell.map(|v| v.to_raw_string()).unwrap_or_default();
        let cell_addr = self.current_cell_address();
        self.set_clipboard(cell_value, format!("Copied cell {}", cell_addr));
    }'''

    content = content.replace(old_copy_cell, new_copy_cell)

    # 4. Update copy_current_row
    old_copy_row = r'''    /// Copy the current row to clipboard (tab-separated)
    fn copy_current_row(&mut self) {
        let (rows, _formulas) = self.sheet_data.get_rows(self.cursor_row, 1);
        let row_values = rows
            .first()
            .map(|row| {
                row.iter()
                    .map(|cell| {
                        let value = cell.to_raw_string();
                        // Escape cells that contain tabs, newlines, or quotes
                        if value.contains('\t') || value.contains('\n') || value.contains('"') {
                            format!("\"{}\"", value.replace('"', "\"\""))
                        } else {
                            value
                        }
                    })
                    .collect::<Vec<_>>()
                    .join("\t")
            })
            .unwrap_or_default();

        match Clipboard::new() {
            Ok(mut clipboard) => {
                if let Err(e) = clipboard.set_text(&row_values) {
                    self.copy_feedback = Some((format!("Copy failed: {}", e), Instant::now()));
                } else {
                    self.copy_feedback = Some((
                        format!(
                            "Copied row {} ({} cells)",
                            self.cursor_row + 1,
                            self.sheet_data.width()
                        ),
                        Instant::now(),
                    ));
                }
            }
            Err(e) => {
                self.copy_feedback = Some((format!("Clipboard error: {}", e), Instant::now()));
            }
        }
    }'''

    new_copy_row = r'''    /// Copy the current row to clipboard (tab-separated)
    fn copy_current_row(&mut self) {
        let (rows, _formulas) = self.sheet_data.get_rows(self.cursor_row, 1);
        let row_values = rows
            .first()
            .map(|row| {
                row.iter()
                    .map(|cell| {
                        let value = cell.to_raw_string();
                        // Escape cells that contain tabs, newlines, or quotes
                        if value.contains('\t') || value.contains('\n') || value.contains('"') {
                            format!("\"{}\"", value.replace('"', "\"\""))
                        } else {
                            value
                        }
                    })
                    .collect::<Vec<_>>()
                    .join("\t")
            })
            .unwrap_or_default();
        let row_num = self.cursor_row + 1;
        let num_cells = self.sheet_data.width();
        self.set_clipboard(
            row_values,
            format!("Copied row {} ({} cells)", row_num, num_cells),
        );
    }'''

    content = content.replace(old_copy_row, new_copy_row)

    with open(path, "w") as f:
        f.write(content)

if __name__ == "__main__":
    patch_cargo_toml()
    patch_tui_rs()
    print("Optimization: Patching complete.")
