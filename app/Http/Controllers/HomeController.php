<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Mocking Auth for demonstration - In real app use Auth::user()
        // $user = Auth::user();
        // $isAdmin = $user && $user->role === 'admin';
        
        // For demo purposes, let's simulate an admin user to show all sections
        // Change to false to see the public view
        $isAdmin = true; 

        $stats = [
            'animais' => 150,
            'tutores' => 85,
            'convenios' => 12,
            'agendamentos' => 45,
            'doacoes' => 28
        ];

        $animaisDoacao = [
            [
                'id' => 1,
                'nome' => 'Rex',
                'especie' => 'Cachorro',
                'idade' => '2 anos',
                'foto_url' => 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?w=500',
            ],
            [
                'id' => 2,
                'nome' => 'Mia',
                'especie' => 'Gato',
                'idade' => '1 ano',
                'foto_url' => 'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=500',
            ],
            [
                'id' => 3,
                'nome' => 'Thor',
                'especie' => 'Cachorro',
                'idade' => '3 anos',
                'foto_url' => 'https://images.unsplash.com/photo-1583511655857-d19b40a7a54e?w=500',
            ],
            [
                'id' => 4,
                'nome' => 'Luna',
                'especie' => 'Gato',
                'idade' => '6 meses',
                'foto_url' => 'https://images.unsplash.com/photo-1573865526739-10659fec78a5?w=500',
            ],
        ];

        $proximosAgendamentos = [
            [
                'id' => 1,
                'animal_nome' => 'Bob',
                'tutor_nome' => 'João Silva',
                'data_agendamento' => '2023-11-25',
                'status' => 'Confirmado'
            ],
            [
                'id' => 2,
                'animal_nome' => 'Nina',
                'tutor_nome' => 'Maria Oliveira',
                'data_agendamento' => '2023-11-26',
                'status' => 'Agendado'
            ],
            [
                'id' => 3,
                'animal_nome' => 'Simba',
                'tutor_nome' => 'Carlos Santos',
                'data_agendamento' => '2023-11-27',
                'status' => 'Agendado'
            ],
        ];

        return view('home', compact('isAdmin', 'stats', 'animaisDoacao', 'proximosAgendamentos'));
    }
}
