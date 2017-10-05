<?php

namespace Build\Core\Tests\Unit\Repositories;

use Build\Core\Tests\AbstractTestCase;
use Illuminate\Database\Eloquent\Collection;
use Build\Core\Contracts\Repositories\Website;
use Build\Core\Repositories\WebsiteRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Build\Core\Eloquent\Models\Website as WebsiteModel;

class WebsiteRepositoryTest extends AbstractTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_create_a_new_repository_instance()
    {
        $this->assertInstanceOf(WebsiteRepository::class, app(Website::class));
    }

    /** @test */
    public function it_can_get_all_websites()
    {
        // Create a new website repository instance.
        $repository = app(WebsiteRepository::class);

        // Create 3 websites.
        factory(WebsiteModel::class, 3)->create();

        // Get all websites.
        $websites = $repository->getAllWebsites();

        $this->assertNotNull($websites);
        $this->assertCount(3, $websites);
        $this->assertInstanceOf(Collection::class, $websites);
    }

    /** @test */
    public function it_can_create_a_new_website()
    {
        // Create a new website repository instance.
        $repository = app(WebsiteRepository::class);

        // Create a new website.
        $website = $repository->createWebsite(
            factory(WebsiteModel::class)->make()->toArray()
        );

        $this->assertNotNull($website);
        $this->assertInstanceOf(WebsiteModel::class, $website);
    }

    /** @test */
    public function it_can_update_an_existing_website()
    {
        // Create a new website repository instance.
        $repository = app(WebsiteRepository::class);

        // Create a new website.
        $website = factory(WebsiteModel::class)->create();

        // Update the website.
        $website = $repository->updateWebsite(
            $website, ['name' => 'New Website Name']
        );

        $this->assertNotNull($website);
        $this->assertInstanceOf(WebsiteModel::class, $website);
        $this->assertEquals($website->name, 'New Website Name');
    }
}
