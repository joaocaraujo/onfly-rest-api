<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Expenses;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExpensesControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test if index requires authentication.
     */
    public function testIndexRequiresAuthentication()
    {
        $response = $this->getJson('/api/expenses');
        $response->assertStatus(401);
    }

    /**
     * Test if user cannot view expenses from other users.
     */
    public function testUserCannotViewExpensesFromOtherUsers()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $token = auth()->login($user);

        Expenses::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/expenses');

        $response->assertJsonMissing(['user_id' => $otherUser->id]);
    }

    /**
     * Test expenses structure.
     */
    public function testUserCanViewTheirExpensesStructure()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);

        Expenses::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/expenses');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'description',
                    'date',
                    'value',
                    'user' => [
                        'id',
                        'name',
                        'email',
                    ],
                ],
            ],
        ]);
    }

    /**
     * Test if user can view specific expense details.
     */
    public function testUserCanViewSpecificExpenseDetails()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);

        $expenses = Expenses::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/expenses');

        foreach ($expenses as $expense) {
            $response->assertJsonFragment([
                'id' => $expense->id,
                'description' => $expense->description,
                'date' => $expense->date,
                'value' => (string)$expense->value,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ]);
        }
    }

    /**
     * Test if user can view an empty expenses list.
     */
    public function testUserCanViewEmptyExpensesList()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/expenses');

        $response->assertStatus(200);
        $response->assertJson(['data' => []]);
    }

    /**
     * Test if user can create an expense.
     */
    public function testUserCanCreateExpense()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);

        $expenseData = [
            'description' => $this->faker->word,
            'value' => $this->faker->randomNumber(2),
            'date' => $this->faker->date(),
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/expenses', $expenseData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('expenses', $expenseData);
    }

    /**
     * Test if storing an expense requires valid data.
     */
    public function testStoreExpenseRequiresValidData()
    {
        $user = User::factory()->create();
        $token = auth()->login($user);

        $invalidExpenseData = [
            'description' => '',
            'date' => 'not_a_date',
            'value' => 'not_a_number',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/expenses', $invalidExpenseData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['description', 'date', 'value']);
    }

    /**
     * Test if storing an expense requires authentication.
     */
    public function testStoreExpenseRequiresAuthentication()
    {
        $expenseData = [
            'description' => 'Teste',
            'value' => 100,
            'date' => '2023-01-01',
        ];
    
        $response = $this->postJson('/api/expenses', $expenseData);
        $response->assertStatus(401);
    }
}
