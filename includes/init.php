<?php
// Inicia la sesión si todavía no fue iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}