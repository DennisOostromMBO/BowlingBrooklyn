CREATE PROCEDURE spGetAllUsers()
BEGIN
    SELECT 
        u.id AS user_id,
        CONCAT(p.first_name, ' ', COALESCE(p.middle_name, ''), ' ', p.last_name) AS full_name,
        u.email,
        u.email_verified_at,
        u.is_logged_in,
        u.logged_in_at,
        u.logged_out_at,
        u.is_active,
        u.comments,
        r.name AS role_name
    FROM 
        users u
    LEFT JOIN 
        roles r ON u.role_id = r.id
    LEFT JOIN 
        persons p ON u.person_id = p.id;
END;