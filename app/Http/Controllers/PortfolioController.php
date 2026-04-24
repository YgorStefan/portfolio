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
            // Backend
            ['name' => 'PHP',        'icon' => 'devicon-php-plain colored',                       'category' => 'backend'],
            ['name' => 'Laravel',    'icon' => 'devicon-laravel-plain colored',                   'category' => 'backend'],
            ['name' => 'MySQL',      'icon' => 'devicon-mysql-plain colored',                     'category' => 'backend'],
            ['name' => 'PostgreSQL', 'icon' => 'devicon-postgresql-plain colored',                'category' => 'backend'],
            ['name' => 'Node.js',    'icon' => 'devicon-nodejs-plain colored',                    'category' => 'backend'],
            ['name' => 'Python',     'icon' => 'devicon-python-plain colored',                    'category' => 'backend'],
            ['name' => 'NoSQL',      'icon' => 'devicon-mongodb-plain colored',                   'category' => 'backend'],
            [
                'name'     => 'IA/ML',
                'icon'     => '',
                'category' => 'backend',
                'svg'      => '<svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" viewBox="0 0 24 24" fill="none" stroke="#a855f7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9.5 2a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5z"/><path d="M14.5 2a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5z"/><path d="M12 9.5V12"/><path d="M9.5 7v2.5"/><path d="M14.5 7v2.5"/><path d="M5 12a7 7 0 0 0 14 0"/><path d="M5 12H3"/><path d="M19 12h2"/><path d="M12 19v2"/><path d="M8.5 17.5l-1.5 1.5"/><path d="M15.5 17.5l1.5 1.5"/></svg>',
            ],
            // Frontend
            ['name' => 'JavaScript',  'icon' => 'devicon-javascript-plain colored',               'category' => 'frontend'],
            ['name' => 'TypeScript',  'icon' => 'devicon-typescript-plain colored',               'category' => 'frontend'],
            ['name' => 'Vue.js',      'icon' => 'devicon-vuejs-plain colored',                    'category' => 'frontend'],
            ['name' => 'React',       'icon' => 'devicon-react-original colored',                 'category' => 'frontend'],
            ['name' => 'Svelte',      'icon' => 'devicon-svelte-plain colored',                   'category' => 'frontend'],
            ['name' => 'Next.js',     'icon' => 'devicon-nextjs-plain',                           'category' => 'frontend'],
            ['name' => 'TailwindCSS', 'icon' => 'devicon-tailwindcss-plain colored',              'category' => 'frontend'],
            ['name' => 'Bootstrap',   'icon' => 'devicon-bootstrap-plain colored',                'category' => 'frontend'],
            ['name' => 'HTML5',       'icon' => 'devicon-html5-plain colored',                    'category' => 'frontend'],
            ['name' => 'CSS3',        'icon' => 'devicon-css3-plain colored',                     'category' => 'frontend'],
            ['name' => 'Vite',        'icon' => 'devicon-vitejs-plain colored',                   'category' => 'frontend'],
            // DevOps
            ['name' => 'Docker',      'icon' => 'devicon-docker-plain colored',                   'category' => 'devops'],
            ['name' => 'Linux',       'icon' => 'devicon-linux-plain',                            'category' => 'devops'],
            ['name' => 'AWS',         'icon' => 'devicon-amazonwebservices-plain-wordmark colored','category' => 'devops'],
            ['name' => 'Git',         'icon' => 'devicon-git-plain colored',                      'category' => 'devops'],
        ];

        return view('pages.home', compact('projects', 'skills'));
    }
}
