<?php

namespace Tests\Feature;

use App\Models\Ritmo;
use App\Models\Tambor;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RitmoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Crear roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'profesor']);
        Role::create(['name' => 'alumno']);
    }

    public function test_profesor_can_create_ritmo(): void
    {
        $profesor = User::factory()->create();
        $profesor->assignRole('profesor');

        $tambor = Tambor::factory()->create();

        $response = $this->actingAs($profesor)->post('/ritmos', [
            'nombre' => 'Test Ritmo',
            'descripcion' => 'Descripción de prueba',
            'bpm_default' => 120,
            'tambores' => [$tambor->id],
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('ritmos', [
            'nombre' => 'Test Ritmo',
            'created_by' => $profesor->id,
        ]);
    }

    public function test_alumno_cannot_create_ritmo(): void
    {
        $alumno = User::factory()->create();
        $alumno->assignRole('alumno');

        $tambor = Tambor::factory()->create();

        $response = $this->actingAs($alumno)->post('/ritmos', [
            'nombre' => 'Test Ritmo',
            'descripcion' => 'Descripción de prueba',
            'bpm_default' => 120,
            'tambores' => [$tambor->id],
        ]);

        $response->assertForbidden();
    }

    public function test_profesor_can_only_edit_own_ritmos(): void
    {
        $profesor1 = User::factory()->create();
        $profesor1->assignRole('profesor');

        $profesor2 = User::factory()->create();
        $profesor2->assignRole('profesor');

        $ritmo = Ritmo::factory()->create([
            'created_by' => $profesor1->id,
        ]);

        // Profesor 1 puede editar
        $response = $this->actingAs($profesor1)->get("/ritmos/{$ritmo->id}/edit");
        $response->assertStatus(200);

        // Profesor 2 no puede editar
        $response = $this->actingAs($profesor2)->get("/ritmos/{$ritmo->id}/edit");
        $response->assertForbidden();
    }

    public function test_admin_can_approve_ritmo(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $profesor = User::factory()->create();
        $profesor->assignRole('profesor');

        $ritmo = Ritmo::factory()->create([
            'created_by' => $profesor->id,
            'approved' => false,
        ]);

        $response = $this->actingAs($admin)->post("/ritmos/{$ritmo->id}/approve");

        $response->assertRedirect();
        $this->assertDatabaseHas('ritmos', [
            'id' => $ritmo->id,
            'approved' => true,
        ]);
    }

    public function test_profesor_cannot_approve_ritmo(): void
    {
        $profesor = User::factory()->create();
        $profesor->assignRole('profesor');

        $ritmo = Ritmo::factory()->create([
            'created_by' => $profesor->id,
            'approved' => false,
        ]);

        $response = $this->actingAs($profesor)->post("/ritmos/{$ritmo->id}/approve");

        $response->assertForbidden();
    }
}

