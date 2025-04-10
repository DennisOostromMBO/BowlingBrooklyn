@vite(['resources/css/app.css', 'resources/js/app.js'])
<x-navbar />

<div class="container mx-auto py-20">
    <h1 class="text-4xl font-bold text-center mb-8">Score Overview</h1>

    <!-- Search Bar -->
    <form method="GET" action="{{ route('scores.index') }}" class="mb-4">
        <input type="text" name="search" placeholder="Search by team name, points or user..." value="{{ request('search') }}" class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg">
    </form>

    @if($scores->isEmpty())
        <p class="text-center text-gray-500">No information available for these scores</p>
    @else
        <table class="w-full border-collapse bg-gray-800 text-gray-200">
            <thead>
                <tr>
                    <th class="border border-gray-700 px-4 py-2">Team</th>
                    <th class="border border-gray-700 px-4 py-2">Points</th>
                    <th class="border border-gray-700 px-4 py-2">Status</th>
                    <th class="border border-gray-700 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($scores as $score)
                    <tr class="hover:bg-gray-700">
                        <td class="border border-gray-700 px-4 py-2">{{ $score->team_name }}</td>
                        <td class="border border-gray-700 px-4 py-2">{{ $score->points }}</td>
                        <td class="border border-gray-700 px-4 py-2">
                            <span class="px-2 py-1 rounded-full {{ $score->status == 'Confirmed' ? 'bg-green-500' : 'bg-yellow-500' }} text-white">
                                {{ $score->status }}
                            </span>
                        </td>
                        <td class="border border-gray-700 px-4 py-2 space-x-2">
                            <button type="button" class="toggle-dropdown bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded" data-team="{{ $score->id }}">View Team</button>
                            
                            @if($score->status != 'Confirmed')
                                <a href="{{ route('scores.edit', $score->id) }}" class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded">Edit</a>
                                
                                <form method="POST" action="{{ route('scores.destroy', $score->id) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this score?')">Delete</button>
                                </form>
                            @else
                                <span class="bg-gray-500 text-white font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed">Edit</span>
                                <span class="bg-gray-500 text-white font-bold py-2 px-4 rounded opacity-50 cursor-not-allowed">Delete</span>
                            @endif
                        </td>
                    </tr>
                    <tr id="team-{{ $score->id }}" class="hidden">
                        <td colspan="4" class="border border-gray-700 px-4 py-2">
                            <table class="w-full border-collapse bg-gray-800 text-gray-200">
                                <thead>
                                    <tr>
                                        <th class="border border-gray-700 px-4 py-2">Teammate</th>
                                        <th class="border border-gray-700 px-4 py-2">Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $teammates = [];
                                        for ($i = 1; $i <= 8; $i++) {
                                            if($score->{"teammate$i"}) {
                                                $teammates[] = [
                                                    'name' => $score->{"teammate$i"},
                                                    'score' => $score->{"teammate{$i}_score"}
                                                ];
                                            }
                                        }
                                        // Sort teammates by score (lowest to highest)
                                        usort($teammates, function($a, $b) {
                                            return $a['score'] - $b['score'];
                                        });
                                    @endphp
                                    
                                    @foreach($teammates as $teammate)
                                        <tr>
                                            <td class="border border-gray-700 px-4 py-2">{{ $teammate['name'] }}</td>
                                            <td class="border border-gray-700 px-4 py-2">{{ $teammate['score'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-4">
            <a href="{{ route('scores.create') }}" class="create bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Add New Score</a>
            <div class="pagination">{{ $scores->links() }}</div>
        </div>
    @endif
</div>

<x-footer />

<script>
    document.querySelectorAll('.toggle-dropdown').forEach(button => {
        button.addEventListener('click', () => {
            const teamId = button.getAttribute('data-team');
            const teamRow = document.getElementById(`team-${teamId}`);
            teamRow.classList.toggle('hidden');
        });
    });
</script>
