CREATE PROCEDURE spGetAllReservations()
BEGIN
    SELECT 
        reservations.id,
        reservations.user_id,
        reservations.ally_number,
        reservations.number_of_persons,
        reservations.reservation_date,
        reservations.isactive,
        reservations.note,
        reservations.created_at,
        reservations.updated_at,
        users.name AS user_name
    FROM 
        reservations
    INNER JOIN 
        users ON reservations.user_id = users.id;
END;
