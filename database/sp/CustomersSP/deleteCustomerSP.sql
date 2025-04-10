CREATE PROCEDURE deleteCustomer(IN customerId INT)
BEGIN
    -- Soft delete in all related tables
    UPDATE persons p
    INNER JOIN customers cu ON p.id = cu.persons_id
    SET p.is_active = false,
        p.updated_at = NOW()
    WHERE cu.id = customerId;

    UPDATE customers cu
    SET cu.is_active = false,
        cu.updated_at = NOW()
    WHERE cu.id = customerId;

    UPDATE contacts c
    SET c.is_active = false,
        c.updated_at = NOW()
    WHERE c.customer_id = customerId;
END;
