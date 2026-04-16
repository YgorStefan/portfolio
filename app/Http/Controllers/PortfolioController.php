<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class PortfolioController extends Controller
{
    public function index(): View
    {
        try {
            $projects = collect(json_decode(
                File::get(base_path('data/projects.json')),
                true
            ) ?? []);
        } catch (\Throwable $e) {
            Log::error('Failed to load projects.json: ' . $e->getMessage());
            $projects = collect([]);
        }

        $skills = [
            // --- Existentes (manter ordem) ---
            ['name' => 'PHP',         'icon' => 'devicon-php-plain colored'],
            ['name' => 'Laravel',     'icon' => 'devicon-laravel-plain colored'],
            ['name' => 'JavaScript',  'icon' => 'devicon-javascript-plain colored'],
            ['name' => 'TypeScript',  'icon' => 'devicon-typescript-plain colored'],
            ['name' => 'Vue.js',      'icon' => 'devicon-vuejs-plain colored'],
            ['name' => 'MySQL',       'icon' => 'devicon-mysql-plain colored'],
            ['name' => 'Git',         'icon' => 'devicon-git-plain colored'],
            ['name' => 'Docker',      'icon' => 'devicon-docker-plain colored'],
            ['name' => 'TailwindCSS', 'icon' => 'devicon-tailwindcss-plain colored'],
            ['name' => 'HTML5',       'icon' => 'devicon-html5-plain colored'],
            ['name' => 'CSS3',        'icon' => 'devicon-css3-plain colored'],
            ['name' => 'Linux',       'icon' => 'devicon-linux-plain'],
            // --- Novas (Devicon) ---
            ['name' => 'PostgreSQL',  'icon' => 'devicon-postgresql-plain colored'],
            ['name' => 'Node.js',     'icon' => 'devicon-nodejs-plain colored'],
            ['name' => 'React',       'icon' => 'devicon-react-original colored'],
            ['name' => 'Python',      'icon' => 'devicon-python-plain colored'],
            ['name' => 'Bootstrap',   'icon' => 'devicon-bootstrap-plain colored'],
            ['name' => 'AWS',         'icon' => 'devicon-amazonwebservices-plain-wordmark colored'],
            // --- IA/ML (SVG inline no Blade — icon vazio intencional) ---
            ['name' => 'IA/ML',       'icon' => ''],
        ];

        return view('pages.home', compact('projects', 'skills'));
    }
}
