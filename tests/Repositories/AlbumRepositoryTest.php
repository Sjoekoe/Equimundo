<?php
namespace Repositories;

use DB;
use EQM\Models\Albums\Album;
use EQM\Models\Albums\AlbumRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AlbumRepositoryTest extends \TestCase
{
    use DatabaseTransactions;

    /**
     * @var \EQM\Models\Albums\AlbumRepository
     */
    protected $albums;

    function setup()
    {
        parent::setup();

        $this->albums = app(AlbumRepository::class);
    }

    /** @test */
    function it_can_find_an_album_by_id()
    {
        $horse = $this->createHorse();
        $album = $this->createAlbum([
            'horse_id' => $horse->id(),
        ]);

        $result = $this->albums->findById($album->id());

        $this->assertEquals(1, count($album));
        $this->assertEquals($album->description(), $result->description());
        $this->assertEquals($album->name(), $result->name());
        $this->assertEquals($album->horse(), $result->horse());
        $this->assertEquals($album->type(), $result->type());
    }

    /** @test */
    function it_can_find_albums_for_a_horse()
    {
        $horse = $this->createHorse();
        $this->createAlbum([
            'horse_id' => $horse->id(),
        ]);
        $this->createAlbum([
            'horse_id' => $horse->id(),
        ]);

        $result = $this->albums->findForHorse($horse);

        $this->assertEquals(2, count($result));
    }

    /** @test */
    function it_can_create_an_album_for_a_horse()
    {
        $horse = $this->createHorse();

        $this->albums->create($horse, [
            'name' => 'Foo',
            'description' => 'bar',
        ]);

        $this->seeInDatabase(Album::TABLE, [
            'id' => DB::table(Album::TABLE)->first()->id,
            'name' => 'Foo',
            'description' => 'Bar',
        ]);
    }

    /** @test */
    function it_can_update_an_album()
    {
        $horse = $this->createHorse();
        $album = $this->createAlbum([
            'horse_id' => $horse->id(),
        ]);

        $result = $this->albums->update($album, [
            'name' => 'Foo',
            'description' => 'Bar',
        ]);

        $this->assertEquals($album->id(), $result->id());
        $this->assertEquals('Foo', $result->name());
        $this->assertEquals('Bar', $result->description());
    }

    /** @test */
    function it_can_delete_an_album()
    {
        $horse = $this->createHorse();
        $album = $this->createAlbum([
            'horse_id' => $horse->id(),
        ]);

        $this->albums->delete($album);

        $this->notSeeInDatabase('albums', [
            'id' => $album->id(),
        ]);
    }

    /** @test */
    function it_can_create_standard_albums_for_a_horse()
    {
        $horse = $this->createHorse();

        $this->albums->createStandardAlbums($horse);

        $this->assertEquals(3, count($horse->albums()));
    }
}
