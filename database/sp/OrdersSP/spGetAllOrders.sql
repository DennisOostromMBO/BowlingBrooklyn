CREATE PROCEDURE spGetAllOrders()
BEGIN
    SELECT 
        orders.id,
        orders.bowling_alleyid,
        orders.product,
        orders.status,
        orders.price,
        orders.total_price,
        orders.isactive,
        orders.note,
        orders.created_at,
        orders.updated_at
    FROM 
        orders;
END;