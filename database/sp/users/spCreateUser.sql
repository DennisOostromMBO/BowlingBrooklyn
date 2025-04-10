CREATE PROCEDURE spCreateUser(
    IN p_first_name VARCHAR(255),
    IN p_middle_name VARCHAR(255),
    IN p_last_name VARCHAR(255),
    IN p_email VARCHAR(255),
    IN p_password VARCHAR(255),
    IN p_date_of_birth DATE,
    IN p_phone VARCHAR(20) -- Add phone number as a parameter
)
BEGIN
    DECLARE p_person_id INT;
    DECLARE p_role_id INT DEFAULT 3;
    DECLARE p_is_active TINYINT DEFAULT 1; 

    -- Insert into the persons table
    INSERT INTO persons (first_name, middle_name, last_name, date_of_birth, is_active, phone)
    VALUES (p_first_name, p_middle_name, p_last_name, p_date_of_birth, p_is_active, p_phone); -- Include phone number

    -- Get the last inserted person_id
    SET p_person_id = LAST_INSERT_ID();

    -- Insert into the users table
    INSERT INTO users (person_id, email, password, role_id, is_active)
    VALUES (p_person_id, p_email, p_password, p_role_id, p_is_active);
END;