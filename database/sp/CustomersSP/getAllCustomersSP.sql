CREATE PROCEDURE getAllCustomers()
BEGIN
    SELECT 
        cu.id,
        p.first_name,
        p.infix,
        p.last_name,
        CASE 
            WHEN TIMESTAMPDIFF(YEAR, p.date_of_birth, CURDATE()) <= 1 THEN 'Baby'
            WHEN TIMESTAMPDIFF(YEAR, p.date_of_birth, CURDATE()) BETWEEN 2 AND 3 THEN 'Peuter'
            WHEN TIMESTAMPDIFF(YEAR, p.date_of_birth, CURDATE()) BETWEEN 4 AND 6 THEN 'Kleuter'
            WHEN TIMESTAMPDIFF(YEAR, p.date_of_birth, CURDATE()) BETWEEN 7 AND 12 THEN 'Kind'
            WHEN TIMESTAMPDIFF(YEAR, p.date_of_birth, CURDATE()) BETWEEN 13 AND 18 THEN 'Tiener'
            WHEN TIMESTAMPDIFF(YEAR, p.date_of_birth, CURDATE()) BETWEEN 19 AND 64 THEN 'Volwassene'
            ELSE 'Oudere'
        END AS age_category,
        c.street_name,
        c.house_number,
        c.addition,
        c.postal_code,
        c.city,
        cu.customer_number,
        u.phone,
        u.email,
        CASE WHEN EXISTS (
            SELECT 1 
            FROM reservations r 
            INNER JOIN users u2 ON r.user_id = u2.id
            WHERE u2.person_id = p.id
        ) THEN 1 ELSE 0 END as has_reservations
    FROM persons p
    INNER JOIN customers cu ON p.id = cu.persons_id
    INNER JOIN contacts c ON cu.id = c.customer_id
    INNER JOIN users u ON p.id = u.person_id
    WHERE cu.is_active = true
    ORDER BY cu.created_at DESC;
END;


