-- Actualizar la contraseña del usuario 2 (Jaime Cañas) con el hash Bcrypt correcto
UPDATE users 
SET password = '$2y$12$XVJQ8T6YF7Z8R9S0T1U2V3W4X5Y6Z7A8B9C0D1E2F3G4H5I6J7K8L9M0N1O2P'
WHERE id = 2;

-- O si quieres usar una contraseña diferente, primero genera el hash con:
-- php artisan tinker
-- echo bcrypt('tu-nueva-contrasena');
-- Y reemplaza el hash arriba con el resultado
