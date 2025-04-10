CREATE PROCEDURE getAllCustomers()
BEGIN
    SELECT 
        cu.id,
        p.first_name,
        p.infix,
        p.last_name,
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


