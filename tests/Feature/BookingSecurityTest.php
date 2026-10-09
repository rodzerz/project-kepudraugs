<?php

namespace Tests\Feature;

use App\Models\Booking;

use App\Models\Pet;

use App\Models\SitterProfile;

use App\Models\User;

use Illuminate\Support\Facades\Schema;

use Tests\TestCase;

class BookingSecurityTest extends TestCase

{

    public function test_guest_cannot_view_owner_bookings(): void

    {

        $response = $this->get('/bookings');

        $response->assertRedirect('/login');

    }

    public function test_guest_cannot_view_sitter_bookings(): void

    {

        $response = $this->get('/bookings/sitter');

        $response->assertRedirect('/login');

    }

    public function test_guest_cannot_create_booking(): void

    {

        $response = $this->post('/bookings', []);

        $response->assertRedirect('/login');

    }

    public function test_testing_environment_uses_in_memory_sqlite(): void

    {

        $this->assertSame('testing', app()->environment());

        $this->assertSame('sqlite', config('database.default'));

        $this->assertSame(

            ':memory:',

            config('database.connections.sqlite.database')

        );

    }

    public function test_required_database_tables_exist(): void

    {

        $this->prepareTestDatabase();

        $this->assertTrue(Schema::hasTable('users'));

        $this->assertTrue(Schema::hasTable('pets'));

        $this->assertTrue(Schema::hasTable('bookings'));

    }

    public function test_owner_cannot_cancel_another_owners_booking(): void

    {

        $this->prepareTestDatabase();

        $owner = User::factory()->create(['role' => 'owner']);

        $anotherOwner = User::factory()->create(['role' => 'owner']);

        $sitter = User::factory()->create(['role' => 'sitter']);

        $booking = $this->createTestBooking(

            $anotherOwner,

            $sitter,

            'pending'

        );

        $response = $this->actingAs($owner)->post(

            "/bookings/{$booking->id}/cancel"

        );

        $response->assertForbidden();

        $this->assertDatabaseHas('bookings', [

            'id' => $booking->id,

            'owner_id' => $anotherOwner->id,

            'status' => 'pending',

        ]);

    }

    public function test_sitter_cannot_cancel_another_sitters_booking(): void

    {

        $this->prepareTestDatabase();

        $owner = User::factory()->create(['role' => 'owner']);

        $sitter = User::factory()->create(['role' => 'sitter']);

        $anotherSitter = User::factory()->create(['role' => 'sitter']);

        $booking = $this->createTestBooking(

            $owner,

            $anotherSitter,

            'accepted'

        );

        $response = $this->actingAs($sitter)->post(

            "/bookings/{$booking->id}/sitter-cancel"

        );

        $response->assertForbidden();

        $this->assertDatabaseHas('bookings', [

            'id' => $booking->id,

            'sitter_id' => $anotherSitter->id,

            'status' => 'accepted',

        ]);

    }

    public function test_owner_cannot_cancel_booking_after_start_time(): void

    {

        $this->prepareTestDatabase();

        $owner = User::factory()->create(['role' => 'owner']);

        $sitter = User::factory()->create(['role' => 'sitter']);

        $booking = $this->createTestBooking(

            $owner,

            $sitter,

            'accepted',

            now()->subDay()->toDateString()

        );

        $response = $this->actingAs($owner)->post(

            "/bookings/{$booking->id}/cancel"

        );

        $response->assertRedirect('/bookings');

        $response->assertSessionHas('error');

        $this->assertDatabaseHas('bookings', [

            'id' => $booking->id,

            'status' => 'accepted',

        ]);

    }

    public function test_sitter_cannot_cancel_booking_after_start_time(): void

    {

        $this->prepareTestDatabase();

        $owner = User::factory()->create(['role' => 'owner']);

        $sitter = User::factory()->create(['role' => 'sitter']);

        $booking = $this->createTestBooking(

            $owner,

            $sitter,

            'accepted',

            now()->subDay()->toDateString()

        );

        $response = $this->actingAs($sitter)->post(

            "/bookings/{$booking->id}/sitter-cancel"

        );

        $response->assertSessionHasErrors('booking');

        $this->assertDatabaseHas('bookings', [

            'id' => $booking->id,

            'status' => 'accepted',

        ]);

    }

    public function test_owner_can_cancel_own_future_pending_booking(): void

    {

        $this->prepareTestDatabase();

        $owner = User::factory()->create(['role' => 'owner']);

        $sitter = User::factory()->create(['role' => 'sitter']);

        $booking = $this->createTestBooking(

            $owner,

            $sitter,

            'pending'

        );

        $response = $this->actingAs($owner)->post(

            "/bookings/{$booking->id}/cancel"

        );

        $response->assertRedirect('/bookings');

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('bookings', [

            'id' => $booking->id,

            'owner_id' => $owner->id,

            'status' => 'cancelled',

        ]);

    }

    public function test_sitter_can_cancel_own_future_accepted_booking(): void

    {

        $this->prepareTestDatabase();

        $owner = User::factory()->create(['role' => 'owner']);

        $sitter = User::factory()->create(['role' => 'sitter']);

        $booking = $this->createTestBooking(

            $owner,

            $sitter,

            'accepted'

        );

        $response = $this->actingAs($sitter)->post(

            "/bookings/{$booking->id}/sitter-cancel"

        );

        $response->assertRedirect('/bookings/sitter');

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('bookings', [

            'id' => $booking->id,

            'sitter_id' => $sitter->id,

            'status' => 'cancelled',

        ]);

    }

    public function test_sitter_can_accept_own_pending_booking(): void

    {

        $this->prepareTestDatabase();

        $owner = User::factory()->create(['role' => 'owner']);

        $sitter = User::factory()->create(['role' => 'sitter']);

        $booking = $this->createTestBooking(

            $owner,

            $sitter,

            'pending'

        );

        $response = $this->actingAs($sitter)->post(

            "/bookings/{$booking->id}/accept"

        );

        $response->assertRedirect('/bookings/sitter');

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('bookings', [

            'id' => $booking->id,

            'sitter_id' => $sitter->id,

            'status' => 'accepted',

        ]);

    }

    public function test_sitter_can_reject_own_pending_booking(): void

    {

        $this->prepareTestDatabase();

        $owner = User::factory()->create(['role' => 'owner']);

        $sitter = User::factory()->create(['role' => 'sitter']);

        $booking = $this->createTestBooking(

            $owner,

            $sitter,

            'pending'

        );

        $response = $this->actingAs($sitter)->post(

            "/bookings/{$booking->id}/reject"

        );

        $response->assertRedirect('/bookings/sitter');

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('bookings', [

            'id' => $booking->id,

            'sitter_id' => $sitter->id,

            'status' => 'rejected',

        ]);

    }

    public function test_sitter_cannot_accept_another_sitters_booking(): void

    {

        $this->prepareTestDatabase();

        $owner = User::factory()->create(['role' => 'owner']);

        $sitter = User::factory()->create(['role' => 'sitter']);

        $anotherSitter = User::factory()->create(['role' => 'sitter']);

        $booking = $this->createTestBooking(

            $owner,

            $anotherSitter,

            'pending'

        );

        $response = $this->actingAs($sitter)->post(

            "/bookings/{$booking->id}/accept"

        );

        $response->assertForbidden();

        $this->assertDatabaseHas('bookings', [

            'id' => $booking->id,

            'sitter_id' => $anotherSitter->id,

            'status' => 'pending',

        ]);

    }

    public function test_sitter_cannot_reject_another_sitters_booking(): void

    {

        $this->prepareTestDatabase();

        $owner = User::factory()->create(['role' => 'owner']);

        $sitter = User::factory()->create(['role' => 'sitter']);

        $anotherSitter = User::factory()->create(['role' => 'sitter']);

        $booking = $this->createTestBooking(

            $owner,

            $anotherSitter,

            'pending'

        );

        $response = $this->actingAs($sitter)->post(

            "/bookings/{$booking->id}/reject"

        );

        $response->assertForbidden();

        $this->assertDatabaseHas('bookings', [

            'id' => $booking->id,

            'sitter_id' => $anotherSitter->id,

            'status' => 'pending',

        ]);

    }

    public function test_sitter_can_complete_own_booking_after_end_time(): void

    {

        $this->prepareTestDatabase();

        $owner = User::factory()->create(['role' => 'owner']);

        $sitter = User::factory()->create(['role' => 'sitter']);

        $booking = $this->createTestBooking(

            $owner,

            $sitter,

            'accepted',

            now()->subDay()->toDateString()

        );

        $response = $this->actingAs($sitter)->post(

            "/bookings/{$booking->id}/complete"

        );

        $response->assertRedirect('/bookings/sitter');

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('bookings', [

            'id' => $booking->id,

            'sitter_id' => $sitter->id,

            'status' => 'completed',

        ]);

    }

    public function test_sitter_cannot_complete_booking_before_end_time(): void

    {

        $this->prepareTestDatabase();

        $owner = User::factory()->create(['role' => 'owner']);

        $sitter = User::factory()->create(['role' => 'sitter']);

        $booking = $this->createTestBooking(

            $owner,

            $sitter,

            'accepted'

        );

        $response = $this->actingAs($sitter)->post(

            "/bookings/{$booking->id}/complete"

        );

        $response->assertRedirect('/bookings/sitter');

        $response->assertSessionHas('error');

        $this->assertDatabaseHas('bookings', [

            'id' => $booking->id,

            'status' => 'accepted',

        ]);

    }

    public function test_sitter_cannot_complete_another_sitters_booking(): void

    {

        $this->prepareTestDatabase();

        $owner = User::factory()->create(['role' => 'owner']);

        $sitter = User::factory()->create(['role' => 'sitter']);

        $anotherSitter = User::factory()->create(['role' => 'sitter']);

        $booking = $this->createTestBooking(

            $owner,

            $anotherSitter,

            'accepted',

            now()->subDay()->toDateString()

        );

        $response = $this->actingAs($sitter)->post(

            "/bookings/{$booking->id}/complete"

        );

        $response->assertForbidden();

        $this->assertDatabaseHas('bookings', [

            'id' => $booking->id,

            'sitter_id' => $anotherSitter->id,

            'status' => 'accepted',

        ]);

    }

    public function test_sitter_cannot_complete_pending_booking(): void

    {

        $this->prepareTestDatabase();

        $owner = User::factory()->create(['role' => 'owner']);

        $sitter = User::factory()->create(['role' => 'sitter']);

        $booking = $this->createTestBooking(

            $owner,

            $sitter,

            'pending',

            now()->subDay()->toDateString()

        );

        $response = $this->actingAs($sitter)->post(

            "/bookings/{$booking->id}/complete"

        );

        $response->assertRedirect('/bookings/sitter');

        $response->assertSessionHas('error');

        $this->assertDatabaseHas('bookings', [

            'id' => $booking->id,

            'status' => 'pending',

        ]);

    }

    public function test_owner_can_create_booking_with_correct_total_price(): void

    {

        $this->prepareTestDatabase();

        $owner = User::factory()->create([

            'role' => 'owner',

        ]);

        $sitter = User::factory()->create([

            'role' => 'sitter',

        ]);

        $pet = Pet::create([

            'user_id' => $owner->id,

            'name' => 'Reksis',

            'species' => 'Suns',

        ]);

        SitterProfile::create([

            'user_id' => $sitter->id,

            'city' => 'Rīga',

            'description' => 'Pieredzējis pieskatītājs.',

            'experience' => '3 gadi',

            'price' => '12.50',

            'accepted_animals' => 'Suņi, kaķi',

        ]);

        $bookingDate = now()->addDays(7)->toDateString();

        $response = $this->actingAs($owner)->post('/bookings', [

            'sitter_id' => $sitter->id,

            'pet_id' => $pet->id,

            'booking_date' => $bookingDate,

            'start_time' => '10:00',

            'end_time' => '12:00',

            'message' => 'Lūdzu pieskatīt Reksi.',

        ]);

        $response->assertRedirect('/dashboard');

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('bookings', [

            'owner_id' => $owner->id,

            'sitter_id' => $sitter->id,

            'pet_id' => $pet->id,

            'pet_type' => 'Suns',

            'booking_date' => $bookingDate,

            'status' => 'pending',

            'total_price' => 25.00,

        ]);

        $this->assertDatabaseHas('messages', [

            'sender_id' => $owner->id,

            'receiver_id' => $sitter->id,

            'message' => 'Lūdzu pieskatīt Reksi.',

        ]);

    }

    public function test_owner_cannot_create_booking_with_another_owners_pet(): void

    {

        $this->prepareTestDatabase();

        $owner = User::factory()->create(['role' => 'owner']);

        $anotherOwner = User::factory()->create(['role' => 'owner']);

        $sitter = User::factory()->create(['role' => 'sitter']);

        $anotherOwnersPet = Pet::create([

            'user_id' => $anotherOwner->id,

            'name' => 'Muris',

            'species' => 'Kakis',

        ]);

        SitterProfile::create([

            'user_id' => $sitter->id,

            'city' => 'Rīga',

            'description' => 'Pieredzējis pieskatītājs.',

            'experience' => '3 gadi',

            'price' => '12.50',

            'accepted_animals' => 'Suņi, kaķi',

        ]);

        $response = $this->actingAs($owner)->post('/bookings', [

            'sitter_id' => $sitter->id,

            'pet_id' => $anotherOwnersPet->id,

            'booking_date' => now()->addDays(7)->toDateString(),

            'start_time' => '10:00',

            'end_time' => '12:00',

            'message' => null,

        ]);

        $response->assertSessionHasErrors('pet_id');

        $this->assertDatabaseMissing('bookings', [

            'owner_id' => $owner->id,

            'pet_id' => $anotherOwnersPet->id,

        ]);

        $this->assertDatabaseCount('bookings', 0);

    }

    public function test_owner_cannot_create_overlapping_booking_for_same_sitter(): void

    {

        $this->prepareTestDatabase();

        $firstOwner = User::factory()->create(['role' => 'owner']);

        $secondOwner = User::factory()->create(['role' => 'owner']);

        $sitter = User::factory()->create(['role' => 'sitter']);

        $pet = Pet::create([

            'user_id' => $secondOwner->id,

            'name' => 'Reksis',

            'species' => 'Suns',

        ]);

        SitterProfile::create([

            'user_id' => $sitter->id,

            'city' => 'Rīga',

            'price' => '12.50',

            'accepted_animals' => 'Suņi, kaķi',

        ]);

        $bookingDate = now()->addDays(7)->toDateString();

        $existingBooking = $this->createTestBooking(

            $firstOwner,

            $sitter,

            'accepted',

            $bookingDate

        );

        // Esošā rezervācija: 10:00–12:00.

        // Jaunā rezervācija: 11:00–13:00 (laiki pārklājas).

        $response = $this->actingAs($secondOwner)->post('/bookings', [

            'sitter_id' => $sitter->id,

            'pet_id' => $pet->id,

            'booking_date' => $bookingDate,

            'start_time' => '11:00',

            'end_time' => '13:00',

            'message' => null,

        ]);

        $response->assertSessionHasErrors();

        $this->assertDatabaseCount('bookings', 1);

        $this->assertDatabaseHas('bookings', [

            'id' => $existingBooking->id,

            'owner_id' => $firstOwner->id,

            'sitter_id' => $sitter->id,

            'status' => 'accepted',

        ]);

        $this->assertDatabaseMissing('bookings', [

            'owner_id' => $secondOwner->id,

            'sitter_id' => $sitter->id,

            'booking_date' => $bookingDate,

        ]);

    }

    public function test_owner_cannot_create_booking_in_the_past(): void

    {

        $this->prepareTestDatabase();

        $owner = User::factory()->create(['role' => 'owner']);

        $sitter = User::factory()->create(['role' => 'sitter']);

        $pet = Pet::create([

            'user_id' => $owner->id,

            'name' => 'Reksis',

            'species' => 'Suns',

        ]);

        SitterProfile::create([

            'user_id' => $sitter->id,

            'city' => 'Rīga',

            'price' => '12.50',

            'accepted_animals' => 'Suņi, kaķi',

        ]);

        $response = $this->actingAs($owner)->post('/bookings', [

            'sitter_id' => $sitter->id,

            'pet_id' => $pet->id,

            'booking_date' => now()->subDay()->toDateString(),

            'start_time' => '10:00',

            'end_time' => '12:00',

            'message' => null,

        ]);

        $response->assertSessionHasErrors('booking_date');

        $this->assertDatabaseCount('bookings', 0);

    }

        public function test_owner_cannot_create_booking_when_end_time_is_before_start_time(): void

    {

        $this->prepareTestDatabase();

        $owner = User::factory()->create(['role' => 'owner']);

        $sitter = User::factory()->create(['role' => 'sitter']);

        $pet = Pet::create([

            'user_id' => $owner->id,

            'name' => 'Reksis',

            'species' => 'Suns',

        ]);

        SitterProfile::create([

            'user_id' => $sitter->id,

            'city' => 'Rīga',

            'price' => '12.50',

            'accepted_animals' => 'Suņi, kaķi',

        ]);

        $response = $this->actingAs($owner)->post('/bookings', [

            'sitter_id' => $sitter->id,

            'pet_id' => $pet->id,

            'booking_date' => now()->addDays(7)->toDateString(),

            'start_time' => '14:00',

            'end_time' => '12:00',

            'message' => null,

        ]);

        $response->assertSessionHasErrors('end_time');

        $this->assertDatabaseCount('bookings', 0);

    }

    public function test_owner_can_create_booking_when_overlapping_booking_is_cancelled(): void
    {
        $this->prepareTestDatabase();

        $firstOwner = User::factory()->create(['role' => 'owner']);
        $secondOwner = User::factory()->create(['role' => 'owner']);
        $sitter = User::factory()->create(['role' => 'sitter']);

        $pet = Pet::create([
            'user_id' => $secondOwner->id,
            'name' => 'Reksis',
            'species' => 'Suns',
        ]);

        SitterProfile::create([
            'user_id' => $sitter->id,
            'city' => 'Rīga',
            'price' => '12.50',
            'accepted_animals' => 'Suņi, kaķi',
        ]);

        $bookingDate = now()->addDays(7)->toDateString();

        $cancelledBooking = $this->createTestBooking(
            $firstOwner,
            $sitter,
            'cancelled',
            $bookingDate
        );

        // Atceltā rezervācija: 10:00–12:00.
        // Jaunā rezervācija: 11:00–13:00.
        $response = $this->actingAs($secondOwner)->post('/bookings', [
            'sitter_id' => $sitter->id,
            'pet_id' => $pet->id,
            'booking_date' => $bookingDate,
            'start_time' => '11:00',
            'end_time' => '13:00',
            'message' => null,
        ]);

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('success');
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseCount('bookings', 2);

        $this->assertDatabaseHas('bookings', [
            'id' => $cancelledBooking->id,
            'owner_id' => $firstOwner->id,
            'sitter_id' => $sitter->id,
            'status' => 'cancelled',
        ]);

        $this->assertDatabaseHas('bookings', [
            'owner_id' => $secondOwner->id,
            'sitter_id' => $sitter->id,
            'pet_id' => $pet->id,
            'booking_date' => $bookingDate,
            'start_time' => '11:00',
            'end_time' => '13:00',
            'status' => 'pending',
            'total_price' => 25.00,
        ]);
    }

    private function prepareTestDatabase(): void

    {

        // Pārbaudām vidi pirms datubāzes atjaunošanas.

        $this->assertSame('testing', app()->environment());

        $this->assertSame('sqlite', config('database.default'));

        $this->assertSame(

            ':memory:',

            config('database.connections.sqlite.database')

        );

        // Atjaunojam tikai izolēto SQLite testa datubāzi.

        $this->artisan('migrate:fresh', [

            '--force' => true,

        ])->assertSuccessful();

    }

    private function createTestBooking(

        User $owner,

        User $sitter,

        string $status,

        ?string $bookingDate = null

    ): Booking {

        return Booking::create([

            'owner_id' => $owner->id,

            'sitter_id' => $sitter->id,

            'pet_id' => null,

            'pet_type' => 'Suns',

            'booking_date' => $bookingDate

                ?? now()->addDays(7)->toDateString(),

            'start_time' => '10:00',

            'end_time' => '12:00',

            'message' => null,

            'status' => $status,

        ]);

    }

}
