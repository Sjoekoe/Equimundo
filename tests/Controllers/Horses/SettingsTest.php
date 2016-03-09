<?php
namespace Controllers\Horses;

use EQM\Models\Horses\Horse;
use EQM\Models\HorseTeams\HorseTeam;

class SettingsTest extends \TestCase
{
    /** @test */
    function it_can_visit_the_settings_page()
    {
        $user = $this->loginAsUser();

        $this->actingAs($user)
            ->withoutMiddleware()
            ->get('settings/horses')
            ->assertResponseStatus(200);
    }

    /** @test */
    function it_can_unlink_a_horse()
    {
        $user = $this->loginAsUser();
        $horse = $this->createHorse();
        $horseTeam = $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);

        $this->actingAs($user)
            ->withoutMiddleware()
            ->get('settings/horses/' . $horse->id() . '/unlink')
            ->assertResponseStatus(302);

        $this->notSeeInDatabase(HorseTeam::TABLE, [
            'id' => $horseTeam->id(),
        ]);

        $this->seeInDatabase(Horse::TABLE, [
            'id' => $horse->id(),
        ]);
    }

    /**
     * @test
     * @expectedException \Symfony\Component\HttpKernel\Exception\HttpException
     */
    function it_can_not_unlink_a_horse_when_you_do_not_belong_to_the_team()
    {
        $user= $this->createUser(['email' => 'test@test.com']);
        $otherUser = $this->loginAsUser();
        $horse = $this->createHorse();
        $horseTeam = $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);

        $this->actingAs($otherUser)
            ->withoutMiddleware()
            ->get('settings/horses/' . $horse->id() . '/unlink')
            ->assertResponseStatus(403);

        $this->seeInDatabase(HorseTeam::TABLE, [
            'id' => $horseTeam->id(),
        ]);

        $this->seeInDatabase(Horse::TABLE, [
            'id' => $horse->id(),
        ]);
    }

    /** @test */
    function it_can_delete_a_horse()
    {
        $user = $this->loginAsUser();
        $horse = $this->createHorse();
        $horseTeam = $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);

        $this->actingAs($user)
            ->withoutMiddleware()
            ->get('settings/horses/' . $horse->id() . '/delete')
            ->assertResponseStatus(302);

        $this->notSeeInDatabase(HorseTeam::TABLE, [
            'id' => $horseTeam->id(),
        ]);

        $this->notSeeInDatabase(Horse::TABLE, [
            'id' => $horse->id(),
        ]);
    }

    /**
     * @test
     * @expectedException \Symfony\Component\HttpKernel\Exception\HttpException
     */
    function it_can_not_delete_a_horse_when_you_are_not_in_the_team()
    {
        $user= $this->createUser(['email' => 'test@test.com']);
        $otherUser = $this->loginAsUser();
        $horse = $this->createHorse();
        $horseTeam = $this->createHorseTeam([
            'user_id' => $user->id(),
            'horse_id' => $horse->id(),
        ]);

        $this->actingAs($otherUser)
            ->withoutMiddleware()
            ->get('settings/horses/' . $horse->id() . '/delete')
            ->assertResponseStatus(403);

        $this->seeInDatabase(HorseTeam::TABLE, [
            'id' => $horseTeam->id(),
        ]);

        $this->seeInDatabase(Horse::TABLE, [
            'id' => $horse->id(),
        ]);
    }
}
