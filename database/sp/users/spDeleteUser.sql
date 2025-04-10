CREATE PROCEDURE spDeleteUser(
    IN p_user_id INT
)
BEGIN
    DECLARE p_person_id INT;
    DECLARE admin_count INT;
    DECLARE user_role INT;

    -- Haal de role_id op van de gebruiker
    SELECT role_id INTO user_role FROM users WHERE id = p_user_id;

    -- Controleer of de gebruiker een administrator is en tel het aantal administrators
    IF user_role = 1 THEN
        SELECT COUNT(*) INTO admin_count FROM users WHERE role_id = 1;

        -- Als er maar één administrator is, beëindig de procedure
        IF admin_count = 1 THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Kan account niet verwijderen: er moet minimaal één administrator zijn.';
        END IF;
    END IF;

    -- Haal de person_id op van de gebruiker
    SELECT person_id INTO p_person_id FROM users WHERE id = p_user_id;

    -- Verwijder de gebruiker uit de users-tabel
    DELETE FROM users WHERE id = p_user_id;

    -- Verwijder de persoon uit de persons-tabel
    DELETE FROM persons WHERE id = p_person_id;
END;