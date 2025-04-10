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
        u.email
    FROM persons p
    INNER JOIN customers cu ON p.id = cu.persons_id
    INNER JOIN contacts c ON cu.id = c.customer_id
    INNER JOIN users u ON p.id = u.person_id
    WHERE cu.is_active = true
    ORDER BY cu.created_at DESC, 
             CAST(SUBSTRING(cu.customer_number, 3) AS UNSIGNED) ASC;
END;


