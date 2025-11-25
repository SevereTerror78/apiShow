<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Film;
use App\Models\User;

class FilmControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;

    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    
    public function test_index_returns_all_film()
    {
        Film::factory()->create(['title' => 'Avatar', 'director_id' =>'1', 'description' =>'alma2222almaalmaalma','release_date' =>'2020.10.10' ,'type_id' => '1', 'length' =>'120']);
        Film::factory()->create(['title' => 'Thank you', 'director_id' =>'1', 'description' =>'alma2222','release_date' =>'2020.10.10' ,'type_id' => '1', 'length' =>'120']);

        $response = $this->getJson('/api/films');

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Avatar', 'director_id' =>'1', 'description' =>'alma2222almaalmaalma2222almaalmaalma', 'release_date' =>'2020.10.10', 'type_id' => '1', 'length' =>'120'])
            ->assertJsonFragment(['title' => 'Thank you', 'director_id' =>'1', 'description' =>'alma2222almaalmaalma2222almaalmaalma', 'release_date' =>'2020.10.10', 'type_id' => '1', 'length' =>'120']);
    } 
    public function test_index_filters_by_needle()
    {
        Film::factory()->create(['title' => 'Avatar', 'director_id' =>'1', 'description' =>'alma2222almaalmaalma2222almaalmaalma','release_date' =>'2020.10.10' ,'type_id' => '1', 'length' =>'120']);
        Film::factory()->create(['title' => 'Thank you', 'director_id' =>'1', 'description' =>'alma2222almaalmaalma2222almaalmaalma','release_date' =>'2020.10.10' ,'type_id' => '1', 'length' =>'120']);

        $response = $this->getJson('/api/films?needle=bar');

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Avatar', 'director_id' =>'1', 'description' =>'alma2222almaalmaalma2222almaalmaalma','release_date' =>'2020.10.10' ,'type_id' => '1', 'length' =>'120']) 
            ->assertJsonMissing(['title' => 'Thank you', 'director_id' =>'1', 'description' =>'alma2222almaalmaalma2222almaalmaalma','release_date' =>'2020.10.10' ,'type_id' => '1', 'length' =>'120']);
    } 

	public function test_store_creates_new_film()
    {
        // Létrehozunk egy felhasználót
		$user = User::factory()->create();
		// Lekérjük a tokent
        $token = $user->createToken('TestToken')->plainTextToken;

		// A Header-ben elküldjük a tokent és meghívjuk a végpontot (postJson) a szükséges adatokkal
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/films', [
            'title' => 'Avatar',
            'director_id' =>'1', 
            'description' =>'alma2222almaalmaalma',
            'release_date' =>'2020.10.10',
            'type_id' => '1', 
            'length' =>'120',
        ]);

		// teszteljük, hogy 200-as kódot kapunk-e és a válaszban benne van-e az újonnan hozzáadott adat.
        $response->assertStatus(201)
            ->assertJsonFragment([
                'title' => 'Avatar',
                'director_id' =>'1', 
                'description' =>'alma2222almaalmaalma',
                'release_date' =>'2020.10.10',
                'type_id' => '1', 
                'length' =>'120',
            ]);
		
		// teszteljük, hogy az adatbázisban is ott van-e at adat
        $this->assertDatabaseHas('films', [
            'title' => 'Avatar',
            'director_id' =>'1', 
            'description' =>'alma2222almaalmaalma',
            'release_date' =>'2020.10.10',
            'type_id' => '1', 
            'length' =>'120',
        ]);
    }
 
	public function test_update_modifies_existing_film()
    {
        $film = Film::factory()->create([
            'title' => 'Avatar',
            'director_id' =>'1', 
            'description' =>'alma2222almaalmaalma',
            'release_date' =>'2020.10.10',
            'type_id' => '1', 
            'length' =>'120',
        ]);

        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->putJson("/api/films/{$film->id}", [
            'title' => 'Avatar2',
            'director_id' =>'1', 
            'description' =>'almaSama',
            'release_date' =>'2020.12.10',
            'type_id' => '2', 
            'length' =>'120',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'title' => 'Avatar2',
                'director_id' =>'1', 
                'description' =>'almaSama',
                'release_date' =>'2020.12.10',
                'type_id' => '2', 
                'length' =>'120',
            ]);

        $this->assertDatabaseHas('films', ['id' => $film->id, 
        'title' => 'Avatar2',
        'director_id' =>'1', 
        'description' =>'almaSama',
        'release_date' =>'2020.12.10',
        'type_id' => '2', 
        'length' =>'120',
    ]);
    } 


    public function test_update_returns_404_for_missing_film()
    {

        $response = $this->putJson('/api/films/999', [
        'title' => 'Az utolsó léghajlító',
        'director_id' =>'1', 
        'description' =>'élőszereplős film',
        'release_date' =>'2020.12.10',
        'type_id' => '2', 
        'length' =>'120',
        ]);

        $response->assertStatus(404)
            ->assertJsonFragment(['message' => 'Not found!']);
    } 

    /**
    * Adatok törlésének tesztelése, hitelesítéssel
    */

    public function test_delete_removes_film()
    {
        $film = Film::factory()->create([        
        'title' => 'Az utolsó léghajlító',
        'director_id' =>'1', 
        'description' =>'élőszereplős film',
        'release_date' =>'2020.12.10',
        'type_id' => '2', 
        'length' =>'120',]);

        $response = $this->deleteJson("/api/films/{$film->id}");

        $response->assertStatus(410)
            ->assertJsonFragment(['message' => 'Deleted']);

        $this->assertDatabaseMissing('films', ['id' => $film->id]);
    } 
	
}
