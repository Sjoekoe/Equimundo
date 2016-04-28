<?php
namespace Controllers\Pedigrees;

use Carbon\Carbon;
use DB;
use EQM\Models\Horses\Horse;
use EQM\Models\Pedigrees\Pedigree;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PedigreeTest extends \TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    /** @test */
    function it_can_show_the_pedigree_page()
    {
        $user = $this->createUser();
        $horse = $this->createHorse([
            'gender' => Horse::MARE,
        ]);
        $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);

        $this->actingAs($user)
            ->visit('/horses/' . $horse->slug() . '/pedigree')
            ->assertResponseStatus(200);
    }

    /** @test */
    function it_can_add_a_father()
    {
        $user = $this->createUser();
        $horse = $this->createHorse([
            'gender' => Horse::MARE,
        ]);
        $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);

        $this->actingAs($user)
            ->post('/horses/' . $horse->slug() . '/pedigree/create', [
                'name' => 'Foo horse',
                'gender' => 1,
                'breed' => 5,
                'type' => Pedigree::FATHER
            ]);

        $this->assertResponseStatus(302);

        $familyId = DB::table(Horse::TABLE)->orderBy('id', 'desc')->first()->id;

        $this->seeInDatabase(Horse::TABLE, [
            'id' => $familyId,
            'name' => 'Foo horse',
        ]);

        $this->seeInDatabase(Pedigree::TABLE, [
            'id' => DB::table(Pedigree::TABLE)->first()->id,
            'horse_id' => $familyId,
            'type' => Pedigree::DAUGHTER,
            'family_id' => $horse->id(),
        ]);

        $this->seeInDatabase(Pedigree::TABLE, [
            'id' => DB::table(Pedigree::TABLE)->orderBy('id', 'desc')->first()->id,
            'horse_id' => $horse->id(),
            'type' => Pedigree::FATHER,
            'family_id' => $familyId,
        ]);
    }

    /** @test */
    function it_can_add_a_mother()
    {
        $user = $this->createUser();
        $horse = $this->createHorse([
            'gender' => Horse::MARE,
        ]);
        $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);

        $this->actingAs($user)
            ->post('/horses/' . $horse->slug() . '/pedigree/create', [
                'name' => 'Foo horse',
                'gender' => 1,
                'breed' => 5,
                'type' => Pedigree::MOTHER
            ]);

        $this->assertResponseStatus(302);

        $familyId = DB::table(Horse::TABLE)->orderBy('id', 'desc')->first()->id;

        $this->seeInDatabase(Horse::TABLE, [
            'id' => $familyId,
            'name' => 'Foo horse',
        ]);

        $this->seeInDatabase('pedigrees', [
            'id' => DB::table(Pedigree::TABLE)->first()->id,
            'horse_id' => $familyId,
            'type' => Pedigree::DAUGHTER,
            'family_id' => $horse->id(),
        ]);

        $this->seeInDatabase('pedigrees', [
            'id' => DB::table(Pedigree::TABLE)->orderBy('id', 'desc')->first()->id,
            'horse_id' => $horse->id(),
            'type' => Pedigree::MOTHER,
            'family_id' => $familyId,
        ]);
    }

    /** @test */
    function it_can_add_a_daughter()
    {
        $user = $this->createUser();
        $horse = $this->createHorse([
            'gender' => Horse::MARE,
        ]);
        $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);

        $this->actingAs($user)
            ->post('/horses/' . $horse->slug() . '/pedigree/create', [
                'name' => 'Foo horse',
                'gender' => 1,
                'breed' => 5,
                'type' => Pedigree::DAUGHTER
            ]);

        $this->assertResponseStatus(302);

        $familyId = DB::table(Horse::TABLE)->orderBy('id', 'desc')->first()->id;

        $this->seeInDatabase(Horse::TABLE, [
            'id' => $familyId,
            'name' => 'Foo horse',
        ]);

        $this->seeInDatabase('pedigrees', [
            'id' => DB::table(Pedigree::TABLE)->first()->id,
            'horse_id' => $familyId,
            'type' => Pedigree::MOTHER,
            'family_id' => $horse->id(),
        ]);

        $this->seeInDatabase('pedigrees', [
            'id' => DB::table(Pedigree::TABLE)->orderBy('id', 'desc')->first()->id,
            'horse_id' => $horse->id(),
            'type' => Pedigree::DAUGHTER,
            'family_id' => $familyId,
        ]);
    }

    /** @test */
    function it_can_add_a_son()
    {
        $user = $this->createUser();
        $horse = $this->createHorse([
            'gender' => Horse::MARE,
        ]);
        $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);

        $this->actingAs($user)
            ->post('/horses/' . $horse->slug() . '/pedigree/create', [
                'name' => 'Foo horse',
                'gender' => 1,
                'breed' => 5,
                'type' => Pedigree::SON
            ]);

        $this->assertResponseStatus(302);

        $familyId = DB::table(Horse::TABLE)->orderBy('id', 'desc')->first()->id;

        $this->seeInDatabase('horses', [
            'id' => $familyId,
            'name' => 'Foo horse',
        ]);

        $this->seeInDatabase('pedigrees', [
            'id' => DB::table(Pedigree::TABLE)->first()->id,
            'horse_id' => $familyId,
            'type' => Pedigree::MOTHER,
            'family_id' => $horse->id(),
        ]);

        $this->seeInDatabase('pedigrees', [
            'id' => DB::table(Pedigree::TABLE)->orderBy('id', 'desc')->first()->id,
            'horse_id' => $horse->id(),
            'type' => Pedigree::SON,
            'family_id' => $familyId,
        ]);
    }

    /** @test */
    function it_will_not_create_an_extra_horse_if_the_life_number_is_known()
    {
        $user = $this->createUser();
        $horse = $this->createHorse([
            'gender' => Horse::MARE,
        ]);
        $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);
        $relative = $this->createHorse([
            'life_number' => '1234',
        ]);

        $this->actingAs($user)
            ->post('/horses/' . $horse->slug() . '/pedigree/create', [
                'name' => 'Foo horse',
                'gender' => 1,
                'breed' => 5,
                'type' => Pedigree::MOTHER,
                'life_number' => $relative->lifeNumber(),
            ]);

        $this->assertResponseStatus(302);

        $this->notSeeInDatabase(Horse::TABLE, [
            'id' => $relative->id() + 1,
        ]);
    }

    /** @test */
    function it_can_not_create_two_higher_pedigrees_of_the_same_type()
    {
        $user = $this->createUser();
        $horse = $this->createHorse([
            'gender' => Horse::MARE,
        ]);
        $relative = $this->createHorse([
            'life_number' => '1234',
        ]);
        $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);
        $this->createPedigree([
            'horse_id' => $horse->id(),
            'type' => Pedigree::MOTHER,
            'family_id' => $relative->id(),
        ]);
        $this->createPedigree([
            'horse_id' => $relative->id(),
            'type' => Pedigree::DAUGHTER,
            'family_id' => $horse->id(),
        ]);

        $this->actingAs($user)
            ->post('/horses/' . $horse->slug() . '/pedigree/create', [
                'name' => 'Foo horse',
                'gender' => 1,
                'breed' => 5,
                'type' => Pedigree::MOTHER,
                'life_number' => $relative->lifeNumber(),
            ]);

        $this->assertResponseStatus(302);

        $this->assertEquals(2, count(DB::table(Pedigree::TABLE)->get()));
    }

    /** @test */
    function it_can_not_add_the_wrong_gender_to_an_already_existing_horse()
    {
        $user = $this->createUser();
        $horse = $this->createHorse([
            'gender' => Horse::MARE,
        ]);
        $relative = $this->createHorse([
            'gender' => Horse::MARE,
            'life_number' => '1234',
        ]);
        $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);

        $this->actingAs($user)
            ->post('/horses/' . $horse->slug() . '/pedigree/create', [
                'name' => 'Foo horse',
                'gender' => 1,
                'breed' => 5,
                'type' => Pedigree::FATHER,
                'life_number' => $relative->lifeNumber(),
            ]);

        $this->assertResponseStatus(302);

        $this->assertEmpty(DB::table(Pedigree::TABLE)->get());
    }

    /** @test */
    function it_can_not_add_a_younger_horse_as_a_parent()
    {
        $user = $this->createUser();
        $horse = $this->createHorse([
            'gender' => Horse::MARE,
            'date_of_birth' => Carbon::now()->subYear(5),
        ]);
        $relative = $this->createHorse([
            'gender' => Horse::STALLION,
            'date_of_birth' => Carbon::now()->subYear(2),
            'life_number' => '1234',
        ]);
        $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);

        $this->actingAs($user)
            ->post('/horses/' . $horse->slug() . '/pedigree/create', [
                'name' => 'Foo horse',
                'gender' => 1,
                'breed' => 5,
                'type' => Pedigree::FATHER,
                'life_number' => $relative->lifeNumber(),
            ]);

        $this->assertResponseStatus(302);

        $this->assertEmpty(DB::table(Pedigree::TABLE)->get());
    }

    /** @test */
    function it_can_not_add_an_older_horse_as_offspring()
    {
        $user = $this->createUser();
        $horse = $this->createHorse([
            'gender' => Horse::MARE,
            'date_of_birth' => Carbon::now()->subYear(4),
        ]);
        $relative = $this->createHorse([
            'gender' => Horse::STALLION,
            'date_of_birth' => Carbon::now()->subYear(5),
            'life_number' => '1234',
        ]);
        $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);

        $this->actingAs($user)
            ->post('/horses/' . $horse->slug() . '/pedigree/create', [
                'name' => 'Foo horse',
                'gender' => 1,
                'breed' => 5,
                'type' => Pedigree::SON,
                'life_number' => $relative->lifeNumber(),
            ]);

        $this->assertResponseStatus(302);

        $this->assertEmpty(DB::table(Pedigree::TABLE)->get());
    }

    /** @test */
    function it_can_add_an_older_parent()
    {
        $user = $this->createUser();
        $horse = $this->createHorse([
            'gender' => Horse::MARE,
            'date_of_birth' => Carbon::now()->subYear(3),
        ]);
        $relative = $this->createHorse([
            'gender' => Horse::STALLION,
            'date_of_birth' => Carbon::now()->subYear(5),
            'life_number' => '1234',
        ]);
        $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);

        $this->actingAs($user)
            ->post('/horses/' . $horse->slug() . '/pedigree/create', [
                'name' => 'Foo horse',
                'gender' => 1,
                'breed' => 5,
                'type' => Pedigree::FATHER,
                'life_number' => $relative->lifeNumber(),
            ]);

        $this->assertResponseStatus(302);

        $this->seeInDatabase(Pedigree::TABLE, [
            'id' => DB::table(Pedigree::TABLE)->first()->id,
        ]);
    }

    /** @test */
    function it_can_add_a_younger_horse_as_offspring()
    {
        $user = $this->createUser();
        $horse = $this->createHorse([
            'gender' => Horse::MARE,
            'date_of_birth' => Carbon::now()->subYear(5)
        ]);
        $relative = $this->createHorse([
            'gender' => Horse::STALLION,
            'date_of_birth' => Carbon::now()->subYear(2),
            'life_number' => '1234',
        ]);
        $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);

        $this->actingAs($user)
            ->post('/horses/' . $horse->slug() . '/pedigree/create', [
                'name' => 'Foo horse',
                'gender' => 1,
                'breed' => 5,
                'type' => Pedigree::SON,
                'life_number' => $relative->lifeNumber(),
            ]);

        $this->assertResponseStatus(302);

        $this->seeInDatabase(Pedigree::TABLE, [
            'id' => DB::table(Pedigree::TABLE)->first()->id,
        ]);
    }

    /** @test */
    function it_can_not_add_offspring_with_a_parent_of_the_same_gender()
    {
        $user = $this->createUser();
        $horse = $this->createHorse([
            'gender' => Horse::MARE,
            'date_of_birth' => Carbon::now()->subYear(5)
        ]);
        $relative = $this->createHorse([
            'life_number' => '1234',
            'date_of_birth' => Carbon::now()->subYear(2),
            'gender' => Horse::STALLION
        ]);
        $relativesParent = $this->createHorse([
            'life_number' => '5678',
            'gender' => Horse::MARE,
        ]);
        $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);
        $this->createPedigree([
            'horse_id' => $relativesParent->id(),
            'type' => Pedigree::SON,
            'family_id' => $relative->id(),
        ]);
        $this->createPedigree([
            'horse_id' => $relative->id(),
            'type' => Pedigree::MOTHER,
            'family_id' => $relativesParent->id(),
        ]);

        $this->actingAs($user)
            ->post('/horses/' . $horse->slug() . '/pedigree/create', [
                'name' => 'Foo horse',
                'gender' => 1,
                'breed' => 5,
                'type' => Pedigree::SON,
                'life_number' => $relative->lifeNumber(),
            ]);

        $this->assertResponseStatus(302);

        $this->assertEquals(2, count(DB::table(Pedigree::TABLE)->get()));
    }
}
