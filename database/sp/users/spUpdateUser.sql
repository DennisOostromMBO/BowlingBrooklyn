CREATE PROCEDURE spUpdateUser(
    IN p_user_id INT,
    IN p_first_name VARCHAR(255),
    IN p_middle_name VARCHAR(255),
    IN p_last_name VARCHAR(255),
    IN p_email VARCHAR(255),
    IN p_role INT,
    IN p_is_active BOOLEAN,
    IN p_comments TEXT
)
BEGIN
    DECLARE p_person_id INT;

    -- Get the person_id from the users table
    SELECT person_id INTO p_person_id FROM users WHERE id = p_user_id;

    -- Update the persons table
    UPDATE persons
    SET 
        first_name = p_first_name,
        middle_name = p_middle_name,
        last_name = p_last_name
    WHERE id = p_person_id;

    -- Update the users table
    UPDATE users
    SET 
        email = p_email,
        role_id = p_role,
        is_active = p_is_active,
        comments = p_comments
    WHERE id = p_user_id;
END;