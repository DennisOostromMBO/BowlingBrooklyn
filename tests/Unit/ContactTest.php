<?php
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock tables
        DB::statement('CREATE TABLE persons (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            first_name TEXT NOT NULL,
            infix TEXT,
            last_name TEXT NOT NULL,
            date_of_birth DATE NOT NULL,
            is_active BOOLEAN NOT NULL,
            note TEXT,
            created_at DATETIME,
            updated_at DATETIME
        )');

        DB::statement('CREATE TABLE customers (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            persons_id INTEGER NOT NULL,
            customer_number TEXT NOT NULL,
            is_active BOOLEAN NOT NULL,
            note TEXT,
            created_at DATETIME,
            updated_at DATETIME,
            FOREIGN KEY (persons_id) REFERENCES persons (id) ON DELETE CASCADE
        )');

        DB::statement('CREATE TABLE contacts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            customer_id INTEGER NOT NULL,
            street_name TEXT NOT NULL,
            house_number TEXT NOT NULL,
            addition TEXT,
            postal_code TEXT NOT NULL,
            city TEXT NOT NULL,
            is_active BOOLEAN NOT NULL,
            created_at DATETIME,
            updated_at DATETIME,
            FOREIGN KEY (customer_id) REFERENCES customers (id) ON DELETE CASCADE
        )');

        DB::statement('CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            person_id INTEGER NOT NULL,
            phone TEXT NOT NULL,
            email TEXT NOT NULL,
            name TEXT NOT NULL,
            roll_id INTEGER NOT NULL,
            password TEXT NOT NULL,
            created_at DATETIME,
            updated_at DATETIME,
            FOREIGN KEY (person_id) REFERENCES persons (id) ON DELETE CASCADE
        )');

        // Mock views to simulate stored procedures
        DB::statement('CREATE VIEW getAllCustomers AS
            SELECT 
                cu.id,
                p.first_name,
                p.infix,
                p.last_name,
                (strftime("%Y", "now") - strftime("%Y", p.date_of_birth)) AS age,
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
            WHERE cu.is_active = 1
            ORDER BY cu.created_at DESC
        ');

        DB::statement('CREATE VIEW getCustomerById AS
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
        ');
    }

    public function test_create_customer()
    {
        $response = $this->post('/customers', [
            'first_name' => 'John',
            'infix' => 'van',
            'last_name' => 'Doe',
            'date_of_birth' => '1990-01-01',
            'street_name' => 'Main Street',
            'house_number' => '123',
            'addition' => 'A',
            'postal_code' => '1234AB',
            'city' => 'Amsterdam',
            'phone' => '0612345678',
            'email' => 'john.doe@example.com',
        ]);

        $response->assertRedirect('/customers');
        $this->assertDatabaseHas('persons', [
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);
    }

    public function test_edit_customer()
    {
        $personId = DB::table('persons')->insertGetId([
            'first_name' => 'Jane',
            'infix' => 'de',
            'last_name' => 'Smith',
            'date_of_birth' => '1985-05-15',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $customerId = DB::table('customers')->insertGetId([
            'persons_id' => $personId,
            'customer_number' => 'BB0001',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->put("/customers/{$customerId}", [
            'first_name' => 'Jane',
            'infix' => 'de',
            'last_name' => 'Doe',
            'date_of_birth' => '1985-05-15',
            'street_name' => 'Second Street',
            'house_number' => '456',
            'addition' => '',
            'postal_code' => '5678CD',
            'city' => 'Rotterdam',
            'phone' => '0612345679',
            'email' => 'jane.doe@example.com',
        ]);

        $response->assertRedirect('/customers');
        $this->assertDatabaseHas('persons', [
            'id' => $personId,
            'last_name' => 'Doe',
        ]);
    }

    public function test_delete_customer()
    {
        $personId = DB::table('persons')->insertGetId([
            'first_name' => 'Mark',
            'infix' => '',
            'last_name' => 'Johnson',
            'date_of_birth' => '1975-03-20',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $customerId = DB::table('customers')->insertGetId([
            'persons_id' => $personId,
            'customer_number' => 'BB0002',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->delete("/customers/{$customerId}");

        $response->assertRedirect('/customers');
        $this->assertDatabaseMissing('customers', [
            'id' => $customerId,
        ]);
    }

    public function test_view_all_customers()
    {
        DB::table('persons')->insert([
            [
                'first_name' => 'Alice',
                'infix' => '',
                'last_name' => 'Brown',
                'date_of_birth' => '1992-07-10',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Bob',
                'infix' => '',
                'last_name' => 'White',
                'date_of_birth' => '1980-11-25',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $response = $this->get('/customers');

        $response->assertStatus(200);
        $response->assertSee('Alice Brown');
        $response->assertSee('Bob White');
    }
}
