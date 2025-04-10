CREATE PROCEDURE updateCustomer(
    IN customerId INT,
    IN p_first_name VARCHAR(255),
    IN p_infix VARCHAR(255),
    IN p_last_name VARCHAR(255),
    IN p_date_of_birth DATE,
    IN p_street_name VARCHAR(255),
    IN p_house_number VARCHAR(10),
    IN p_addition VARCHAR(10),
    IN p_postal_code VARCHAR(10),
    IN p_city VARCHAR(255),
    IN p_phone VARCHAR(20),
    IN p_email VARCHAR(255)
)
BEGIN
    -- Update person
    UPDATE persons p 
    INNER JOIN customers cu ON p.id = cu.persons_id
    SET 
        p.first_name = p_first_name,
        p.infix = p_infix,
        p.last_name = p_last_name,
        p.date_of_birth = p_date_of_birth,
        p.updated_at = NOW()
    WHERE cu.id = customerId;

    -- Update contact
    UPDATE contacts c
    SET 
        c.street_name = p_street_name,
        c.house_number = p_house_number,
        c.addition = p_addition,
        c.postal_code = p_postal_code,
        c.city = p_city,
        c.updated_at = NOW()
    WHERE c.customer_id = customerId;

    -- Update user
    UPDATE users u
    INNER JOIN persons p ON u.person_id = p.id
    INNER JOIN customers cu ON p.id = cu.persons_id
    SET 
        u.phone = p_phone,
        u.email = p_email,
        u.updated_at = NOW()
    WHERE cu.id = customerId;
END;
