CREATE PROCEDURE spGetAllOrders()
BEGIN
    SELECT 
        Orders.id,
        Orders.user_id,
        Orders.bowling_alley_id,
        Orders.Total_price,
        Orders.product,
        Orders.isactive,
        Orders.note,
        Orders.created_at,
        Orders.updated_at,
        users.name AS user_name
    FROM 
        reservations
    INNER JOIN 
        users ON reservations.user_id = users.id;
END;