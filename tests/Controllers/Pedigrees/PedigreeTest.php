<?php
namespace Controllers\Pedigrees;

use Carbon\Carbon;
use EQM\Models\Horses\EloquentHorse;
use EQM\Models\Horses\Horse;
use EQM\Models\HorseTeams\EloquentHorseTeam;
use EQM\Models\Pedigrees\EloquentPedigree;
use EQM\Models\Pedigrees\Pedigree;
use EQM\Models\Users\EloquentUser;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PedigreeTest extends \TestCase
{
    use WithoutMiddleware;

    /** @test */
    function it_can_show_the_pedigree_page()
    {
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create([
            'gender' => Horse::MARE,
        ]);
        factory(EloquentHorseTeam::class)->create([
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
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create([
            'gender' => Horse::MARE,
        ]);
        factory(EloquentHorseTeam::class)->create([
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

        $this->seeInDatabase('horses', [
            'id' => 2,
            'name' => 'Foo horse',
        ]);

        $this->seeInDatabase('pedigrees', [
            'id' => 1,
            'horse_id' => 2,
            'type' => Pedigree::DAUGHTER,
            'family_id' => $horse->id(),
        ]);

        $this->seeInDatabase('pedigrees', [
            'id' => 2,
            'horse_id' => $horse->id(),
            'type' => Pedigree::FATHER,
            'family_id' => 2,
        ]);
    }

    /** @test */
    function it_can_add_a_mother()
    {
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create([
            'gender' => Horse::MARE,
        ]);
        factory(EloquentHorseTeam::class)->create([
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

        $this->seeInDatabase('horses', [
            'id' => 2,
            'name' => 'Foo horse',
        ]);

        $this->seeInDatabase('pedigrees', [
            'id' => 1,
            'horse_id' => 2,
            'type' => Pedigree::DAUGHTER,
            'family_id' => $horse->id(),
        ]);

        $this->seeInDatabase('pedigrees', [
            'id' => 2,
            'horse_id' => $horse->id(),
            'type' => Pedigree::MOTHER,
            'family_id' => 2,
        ]);
    }

    /** @test */
    function it_can_add_a_daughter()
    {
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create([
            'gender' => Horse::MARE,
        ]);
        factory(EloquentHorseTeam::class)->create([
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

        $this->seeInDatabase('horses', [
            'id' => 2,
            'name' => 'Foo horse',
        ]);

        $this->seeInDatabase('pedigrees', [
            'id' => 1,
            'horse_id' => 2,
            'type' => Pedigree::MOTHER,
            'family_id' => $horse->id(),
        ]);

        $this->seeInDatabase('pedigrees', [
            'id' => 2,
            'horse_id' => $horse->id(),
            'type' => Pedigree::DAUGHTER,
            'family_id' => 2,
        ]);
    }

    /** @test */
    function it_can_add_a_son()
    {
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create([
            'gender' => Horse::MARE,
        ]);
        factory(EloquentHorseTeam::class)->create([
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

        $this->seeInDatabase('horses', [
            'id' => 2,
            'name' => 'Foo horse',
        ]);

        $this->seeInDatabase('pedigrees', [
            'id' => 1,
            'horse_id' => 2,
            'type' => Pedigree::MOTHER,
            'family_id' => $horse->id(),
        ]);

        $this->seeInDatabase('pedigrees', [
            'id' => 2,
            'horse_id' => $horse->id(),
            'type' => Pedigree::SON,
            'family_id' => 2,
        ]);
    }

    /** @test */
    function it_will_not_create_an_extra_horse_if_the_life_number_is_known()
    {
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create([
            'gender' => Horse::MARE,
        ]);
        $relative = factory(EloquentHorse::class)->create([
            'life_number' => '1234',
        ]);
        factory(EloquentHorseTeam::class)->create([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
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

        $this->notSeeInDatabase('horses', [
            'id' => 3,
        ]);
    }

    /** @test */
    function it_can_not_create_two_higher_pedigrees_of_the_same_type()
    {
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create([
            'gender' => Horse::MARE,
        ]);
        $relative = factory(EloquentHorse::class)->create([
            'life_number' => '1234',
        ]);
        factory(EloquentHorseTeam::class)->create([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);
        factory(EloquentPedigree::class)->create([
            'horse_id' => $horse->id(),
            'type' => Pedigree::MOTHER,
            'family_id' => $relative->id(),
        ]);
        factory(EloquentPedigree::class)->create([
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
        $this->notSeeInDatabase('pedigrees', [
            'id' => 3,
        ]);
    }

    /** @test */
    function it_can_not_add_the_wrong_gender_to_an_already_existing_horse()
    {
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create([
            'gender' => Horse::MARE,
        ]);
        $relative = factory(EloquentHorse::class)->create([
            'gender' => Horse::MARE,
            'life_number' => '1234',
        ]);
        factory(EloquentHorseTeam::class)->create([
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

        $this->notSeeInDatabase('pedigrees', [
            'id' => 1,
        ]);
    }

    /** @test */
    function it_can_not_add_a_younger_horse_as_a_parent()
    {
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create([
            'gender' => Horse::MARE,
            'date_of_birth' => Carbon::now()->subYear(5),
        ]);
        $relative = factory(EloquentHorse::class)->create([
            'gender' => Horse::STALLION,
            'date_of_birth' => Carbon::now()->subYear(2),
            'life_number' => '1234',
        ]);
        factory(EloquentHorseTeam::class)->create([
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

        $this->notSeeInDatabase('pedigrees', [
            'id' => 1,
        ]);
    }

    /** @test */
    function it_can_not_add_an_older_horse_as_offspring()
    {
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create([
            'gender' => Horse::MARE,
            'date_of_birth' => Carbon::now()->subYear(4),
        ]);
        $relative = factory(EloquentHorse::class)->create([
            'gender' => Horse::STALLION,
            'date_of_birth' => Carbon::now()->subYear(5),
            'life_number' => '1234',
        ]);
        factory(EloquentHorseTeam::class)->create([
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

        $this->notSeeInDatabase('pedigrees', [
            'id' => 1,
        ]);
    }

    /** @test */
    function it_can_add_an_older_parent()
    {
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create([
            'gender' => Horse::MARE,
            'date_of_birth' => Carbon::now()->subYear(3),
        ]);
        $relative = factory(EloquentHorse::class)->create([
            'gender' => Horse::STALLION,
            'date_of_birth' => Carbon::now()->subYear(5),
            'life_number' => '1234',
        ]);
        factory(EloquentHorseTeam::class)->create([
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

        $this->seeInDatabase('pedigrees', [
            'id' => 1,
        ]);
    }

    /** @test */
    function it_can_add_a_younger_horse_as_offspring()
    {
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create([
            'gender' => Horse::MARE,
            'date_of_birth' => Carbon::now()->subYear(5)
        ]);
        $relative = factory(EloquentHorse::class)->create([
            'gender' => Horse::STALLION,
            'date_of_birth' => Carbon::now()->subYear(2),
            'life_number' => '1234',
        ]);
        factory(EloquentHorseTeam::class)->create([
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

        $this->seeInDatabase('pedigrees', [
            'id' => 1,
        ]);
    }

    function it_can_not_add_offspring_with_a_parent_of_the_same_gender()
    {
        $user = factory(EloquentUser::class)->create();
        $horse = factory(EloquentHorse::class)->create([
            'gender' => Horse::MARE,
            'date_of_birth' => Carbon::now()->subYear(5)
        ]);
        $relative = factory(EloquentHorse::class)->create([
            'life_number' => '1234',
            'date_of_birth' => Carbon::now()->subYear(2),
            'gender' => Horse::STALLION
        ]);
        $relativesParent = factory(EloquentHorse::class)->create([
            'life_number' => '5678',
            'gender' => Horse::MARE,
        ]);
        factory(EloquentHorseTeam::class)->create([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);
        factory(EloquentPedigree::class)->create([
            'horse_id' => $relativesParent->id(),
            'type' => Pedigree::MOTHER,
            'family_id' => $relative->id(),
        ]);
        factory(EloquentPedigree::class)->create([
            'horse_id' => $relative->id(),
            'type' => Pedigree::SON,
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

        $this->notSeeInDatabase('pedigrees', [
            'id' => 3,
        ]);
    }
}
