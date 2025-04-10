CREATE PROCEDURE spCreateReservation(
    IN user_id INT,
    IN ally_number INT,
    IN number_of_persons INT,
    IN reservation_date DATE,
    IN note TEXT
)
BEGIN
    INSERT INTO reservations (
        user_id,
        ally_number,
        number_of_persons,
        reservation_date,
        isactive,
        note,
        created_at,
        updated_at
    )
    VALUES (
        user_id,
        ally_number,
        number_of_persons,
        reservation_date,
        TRUE, -- Automatically set isactive to TRUE
        note,
        NOW(),
        NOW()
    );
END;