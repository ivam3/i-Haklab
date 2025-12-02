# Markdown Viewer

![Application Logo](markdown_viewer_app/src/assets/logo-IbyC-circulo.png)

## Overview

**Markdown Viewer** is a lightweight application designed to display Markdown (`.md`) text files. Developed entirely in Python using the `flet` module, this tool was conceived to function efficiently in mobile environments, particularly on the Android operating system via the [Termux terminal emulator](https://github.com/termux/termux-app).

The primary motivation for its creation arose from the need for a native and functional Markdown viewer directly within Termux, an environment where existing solutions were limited or nonexistent.

## Features

*   **Markdown Visualization:** Renders `.md` files cleanly and legibly.
*   **Responsive Design:** Interface adapted for different screen sizes, ideal for mobile devices.
*   **Termux Integration:** Optimized for smooth performance within the Termux ecosystem.
*   **Developed in Python/Flet:** Utilizes a modern technology stack that allows for rapid development and an attractive user interface.

## Installation

### Requirements

*   Python 3.x
*   PIP (Python Package Manager)
*   Termux (if installing on Android)
*   `flet` module

### Installation Steps (for Termux/Android)

1.  **Update Termux:**
    ```bash
    pkg update && pkg upgrade
    ```

2.  **Install Python and PIP:**
    ```bash
    pkg install python python-pip
    ```

3.  **Clone the Repository:**
    ```bash
    git clone https://github.com/tu_usuario/markdown-viewer.git
    cd markdown-viewer
    ```
    (Note: Replace `https://github.com/tu_usuario/markdown-viewer.git` with the actual URL of your repository if different.)

4.  **Install Dependencies:**
    ```bash
    pip install -r markdown_viewer_app/requirements.txt
    ```

## Usage

To start the application, navigate to the `markdown_viewer_app` directory and run the `main.py` script:

```bash
cd markdown_viewer_app/src
python main.py
```

The application will open, allowing you to browse and view your Markdown files.

## Contributions

Contributions are welcome. If you have suggestions, improvements, or find any bugs, feel free to open an "issue" or submit a "pull request" on the GitHub repository.

## License

This project is licensed under the GNU License. See the [LICENSE](LICENSE) file for more details.

##### Follow me on [Socials Network](https://link.space/@ivam3)
---

**Developed by Ivam3byCinderella**
