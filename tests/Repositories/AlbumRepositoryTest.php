<?php
namespace Repositories;

use EQM\Models\Albums\AlbumRepository;
use EQM\Models\Albums\EloquentAlbum;
use EQM\Models\Horses\EloquentHorse;

class AlbumRepositoryTest extends \TestCase
{
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
        $horse = factory(EloquentHorse::class)->create();
        $album = factory(EloquentAlbum::class)->create([
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
        $horse = factory(EloquentHorse::class)->create();
        factory(EloquentAlbum::class)->create([
            'horse_id' => $horse->id(),
        ]);
        factory(EloquentAlbum::class)->create([
            'horse_id' => $horse->id(),
        ]);

        $result = $this->albums->findForHorse($horse);

        $this->assertEquals(2, count($result));
    }

    /** @test */
    function it_can_create_an_album_for_a_horse()
    {
        $horse = factory(EloquentHorse::class)->create();

        $this->albums->create($horse, [
            'name' => 'Foo',
            'description' => 'bar',
        ]);

        $this->seeInDatabase('albums', [
            'id' => 1,
            'name' => 'Foo',
            'description' => 'Bar',
        ]);
    }

    /** @test */
    function it_can_update_an_album()
    {
        $horse = factory(EloquentHorse::class)->create();
        $album = factory(EloquentAlbum::class)->create([
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
        $horse = factory(EloquentHorse::class)->create();
        $album = factory(EloquentAlbum::class)->create([
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
        $horse = factory(EloquentHorse::class)->create();

        $this->albums->createStandardAlbums($horse);

        $this->assertEquals(3, count($horse->albums()));
    }
}
