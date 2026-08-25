# NtlmRelayx

## ¿Qué es NtlmRelayx?

NtlmRelayx es una herramienta de la suite **Impacket** (Fortra) que automatiza el **ataque de retransmisión NTLM (NTLM Relay Attack)**. En lugar de intentar descifrar el hash NTLMv1/NTLMv2 capturado, la herramienta lo **retransmite en tiempo real** a otro servicio de la red para autenticarse como la víctima sin conocer su contraseña.

## ¿Para qué es útil la herramienta?

Es una de las herramientas más potentes en **redes Windows / Active Directory** para movimientos laterales:

-   **Movimiento lateral sin contraseña:** Captura la autenticación NTLM de una víctima (p. ej. cuando visita un recurso SMB controlado por el atacante) y la retransmite contra otros hosts/servicios.
-   **Ataques a LDAP/SAMR:** Delegación de acceso (Resource-Based Constrained Delegation), creación de usuarios, modificación de atributos, escalada a Domain Admin.
-   **Dump de credenciales:** `--dump-shares`, `--dump-laps`, `-i` (consola interactiva), etc.
-   **Servidores SOCKS:** Con `-socks`, permite pivotar a través de las sesiones retransmitidas.
-   **Múltiples protocolos:** SMB, HTTP/HTTPS, LDAP, MSSQL, IMAP, POP3, WinRM, RDP (con restricciones), etc.

## ¿Cómo se usa?

El flujo típico: la víctima debe autenticarse contra el atacante (p. ej. al descubrir un recurso de red malicioso o mediante un `responder` en la misma red).

```bash
# Retransmitir a un objetivo SMB con lista de usuarios/contraseñas de target
ntlmrelayx -t smb://192.168.1.10 -tf targets.txt

# Retransmitir a LDAP para delegación de acceso (escalada en AD)
ntlmrelayx -t ldap://dc.example.com --delegate-access

# Activar servidor SOCKS y dump de cuentas/hashes
ntlmrelayx -tf targets.txt -smb2support -socks --dump-hashes
```

## Consideraciones Adicionales

-   **Requisitos:** Requiere estar en la misma red que la víctima o que esta se conecte a un recurso controlado por el atacante (comúnmente se combina con `Responder` en modo off).
-   **SMBv2:** Algunos objetivos exigen `-smb2support`; el uso de SMB signing (obligatorio en redes bien configuradas) puede impedir el ataque.
-   **Impacket:** Se instala automáticamente vía `pip install impacket`. En Termux/i-HakLab, la herramienta se ejecuta como un script Python en `~/.local/share/ntlmrelayx/`.
-   **Autorización:** Solo debe usarse en pruebas de penetración con autorización explícita. La retransmisión NTLM es una técnica ofensiva de alto impacto.

---
*Nota: La información proporcionada aquí es para fines educativos y de pruebas de seguridad autorizadas.*