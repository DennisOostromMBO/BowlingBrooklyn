CREATE PROCEDURE spUpdateUserPassword(
    IN p_user_id INT,
    IN p_password VARCHAR(255)
)
BEGIN
    -- Update the users table
    UPDATE users
    SET 
        password = p_password
    WHERE id = p_user_id;
END;