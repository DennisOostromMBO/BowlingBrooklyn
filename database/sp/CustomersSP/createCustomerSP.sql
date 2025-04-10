CREATE PROCEDURE createCustomer(
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
    DECLARE new_person_id INT;
    DECLARE new_customer_id INT;
    DECLARE next_number INT;

    START TRANSACTION;

    -- Get next customer number
    SELECT COALESCE(MAX(CAST(SUBSTRING(customer_number, 3) AS UNSIGNED)), 0) + 1
    INTO next_number
    FROM customers;

    -- Insert person
    INSERT INTO persons (
        first_name, 
        infix, 
        last_name,
        date_of_birth,
        is_active,
        created_at,
        updated_at
    ) VALUES (
        p_first_name, 
        p_infix, 
        p_last_name,
        p_date_of_birth,
        true,
        NOW(),
        NOW()
    );
    
    SET new_person_id = LAST_INSERT_ID();

    -- Insert customer
    INSERT INTO customers (
        persons_id,
        customer_number,
        is_active,
        created_at,
        updated_at
    ) VALUES (
        new_person_id,
        CONCAT('BB', LPAD(next_number, 3, '0')),
        true,
        NOW(),
        NOW()
    );
    
    SET new_customer_id = LAST_INSERT_ID();

    -- Insert contact
    INSERT INTO contacts (
        customer_id,
        street_name,
        house_number,
        addition,
        postal_code,
        city,
        is_active,
        created_at,
        updated_at
    ) VALUES (
        new_customer_id,
        p_street_name,
        p_house_number,
        p_addition,
        p_postal_code,
        p_city,
        true,
        NOW(),
        NOW()
    );

    -- Insert user with minimal required fields
    INSERT INTO users (
        person_id,
        phone,
        email,
        name,
        roll_id,
        password,
        created_at,
        updated_at
    ) VALUES (
        new_person_id,
        p_phone,
        p_email,
        CONCAT(p_first_name, ' ', IFNULL(CONCAT(p_infix, ' '), ''), p_last_name),
        2,
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- default hashed password: 'password'
        NOW(),
        NOW()
    );

    COMMIT;

    -- Return the created customer
    SELECT 
        cu.id,
        p.first_name,
        p.infix,
        p.last_name,
        p.date_of_birth,
        c.street_name,
        c.house_number,
        c.addition,
        c.postal_code,
        c.city,
        cu.customer_number,
        u.phone,
        u.email
    FROM persons p
    INNER JOIN customers cu ON p.id = cu.persons_id
    INNER JOIN contacts c ON cu.id = c.customer_id
    INNER JOIN users u ON p.id = u.person_id
    WHERE cu.id = new_customer_id;
END;
