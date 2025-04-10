@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-navbar />

<div class="container mx-auto py-20">
    <h1 class="text-4xl font-bold text-center mb-8">Add Scores</h1>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
            <h3 class="font-bold mb-2">There were some errors with your submission:</h3>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Leader Selection -->
    <form id="leader-form" method="GET" action="{{ route('scores.create') }}" class="mb-4">
        <label for="leader" class="block text-gray-200">Select Leader</label>
        <select id="leader" name="leader" class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg" required>
            <option value="">-- Selecteer Team --</option>
            @foreach($reservations as $reservation)
                <option value="{{ $reservation->id }}" {{ request('leader') == $reservation->id ? 'selected' : '' }}>{{ $reservation->user_name }}</option>
            @endforeach
        </select>
        <button type="submit" class="create bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mt-4">Volgende</button>
    </form>

    @if(request('leader'))
        <div class="flex flex-col md:flex-row">
            <!-- Score Input for Each Person -->
            <form id="scores-form" method="POST" action="{{ route('scores.store') }}" class="bg-gray-800 p-6 rounded-lg shadow-lg w-full md:w-1/2" onsubmit="return validateForm()">
                @csrf
                <input type="hidden" name="reservation_id" value="{{ request('leader') }}">

                <h2 class="text-2xl font-bold text-center mb-4">Scores invoeren voor {{ $leaderName }}</h2>

                <!-- Add team name field -->
                <div class="mb-4">
                    <label for="team_name" class="block text-gray-200">Team Naam</label>
                    <input type="text" id="team_name" name="team_name" class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg" placeholder="Voer een teamnaam in" value="{{ $leaderName ? $leaderName . '\'s Team' : old('team_name') }}">
                    <p class="text-sm text-gray-400">Leave blank to use the default name</p>
                </div>

                <!-- Registered Participants -->
                @foreach($participants as $participant)
                    <div class="mb-4">
                        <label for="score_{{ $participant->id }}" class="block text-gray-200">{{ $participant->name }}</label>
                        <input type="number" id="score_{{ $participant->id }}" name="scores[{{ $participant->id }}]" class="score-input w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg" required min="0" max="300" value="{{ old("scores.{$participant->id}") }}">
                        <p class="text-sm text-gray-400 mt-1">Maximum score is 300.</p>
                        <input type="hidden" name="participant_names[{{ $participant->id }}]" value="{{ $participant->name }}">
                    </div>
                @endforeach

                <!-- Add New Teammate Section -->
                <div class="mb-4">
                    <h3 class="text-xl font-bold text-center mb-4">Teamlid Toevoegen</h3>
                    <div class="flex items-center space-x-4">
                        <input type="text" id="new_teammate_name" placeholder="Naam Teamlid" class="w-1/2 px-4 py-2 bg-gray-700 text-gray-200 rounded-lg">
                        <input type="number" id="new_teammate_score" placeholder="Score" class="w-1/4 px-4 py-2 bg-gray-700 text-gray-200 rounded-lg" min="0" max="300">
                        <button type="button" id="add-teammate" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Toevoegen</button>
                    </div>
                    <p class="text-sm text-gray-400 mt-1">De score van een teamlid kan maximaal 300 zijn.</p>
                    <p id="teammate-error" class="text-red-500 mt-2 hidden">Maximum of 8 teammates reached!</p>
                </div>

                <button type="submit" class="create mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Save Game</button>
            </form>

            <!-- Live Rankings -->
            <div class="w-full md:w-1/2 md:ml-4 mt-4 md:mt-0">
                <table class="w-full border-collapse bg-gray-800 text-gray-200">
                    <thead>
                        <tr>
                            <th class="border border-gray-700 px-4 py-2">Naam</th>
                            <th class="border border-gray-700 px-4 py-2">Score</th>
                            <th class="border border-gray-700 px-4 py-2">Acties</th>
                        </tr>
                    </thead>
                    <tbody id="rankings">
                        @foreach($participants as $participant)
                            <tr data-id="{{ $participant->id }}" class="registered-member">
                                <td class="border border-gray-700 px-4 py-2">{{ $participant->name }}</td>
                                <td class="border border-gray-700 px-4 py-2" id="score_display_{{ $participant->id }}">0</td>
                                <td class="border border-gray-700 px-4 py-2">
                                    <!-- Can't delete registered members -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

<x-footer />

<script>
    let teammateCount = {{ count($participants ?? []) }};
    const maxTeammates = 8;

    // Form validation
    function validateForm() {
        let isValid = true;
        const scoreInputs = document.querySelectorAll('.score-input');

        scoreInputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('border-red-500');

                // Create error message if not exists
                if (!input.nextElementSibling.classList.contains('error-message')) {
                    const errorMsg = document.createElement('p');
                    errorMsg.className = 'text-red-500 text-sm mt-1 error-message';
                    errorMsg.textContent = 'Alle velden zijn verplicht';
                    input.parentNode.insertBefore(errorMsg, input.nextSibling);
                }
            } else {
                input.classList.remove('border-red-500');
                const errorMsg = input.nextElementSibling;
                if (errorMsg && errorMsg.classList.contains('error-message')) {
                    errorMsg.remove();
                }
            }
        });

        if (!isValid) {
            // Show general error at the top
            const formElement = document.getElementById('scores-form');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'bg-red-500 text-white p-4 rounded-lg mb-6';
            errorDiv.innerHTML = '<p>Alle velden zijn verplicht</p>';

            // Only add if not already present
            const existingError = formElement.querySelector('.bg-red-500');
            if (!existingError) {
                formElement.prepend(errorDiv);
            }
        }

        return isValid;
    }

    // Update scores in live ranking for registered members
    document.querySelectorAll('.score-input').forEach(input => {
        input.addEventListener('input', () => {
            const id = input.id.split('_')[1];
            document.getElementById(`score_display_${id}`).textContent = input.value || 0;
            sortRankings();
        });
    });

    // Add new member to both form and live rankings
    document.getElementById('add-teammate')?.addEventListener('click', () => {
        if (teammateCount >= maxTeammates) {
            document.getElementById('teammate-error').classList.remove('hidden');
            return;
        }

        const name = document.getElementById('new_teammate_name').value.trim();
        const score = document.getElementById('new_teammate_score').value.trim();

        if (!name || !score) {
            alert('Beide velden zijn verplicht voor een nieuw teamlid.');
            return;
        }

        // Add the new teammate to the rankings table
        const rankings = document.getElementById('rankings');
        const newRow = document.createElement('tr');
        const uniqueId = `new_${Date.now()}`;
        newRow.setAttribute('data-id', uniqueId);
        newRow.setAttribute('data-score', score);
        newRow.innerHTML = `
            <td class="border border-gray-700 px-4 py-2">${name}</td>
            <td class="border border-gray-700 px-4 py-2" id="score_display_${uniqueId}">${score}</td>
            <td class="border border-gray-700 px-4 py-2">
                <button type="button" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded" onclick="removeTeammate('${uniqueId}')">Verwijderen</button>
            </td>
        `;
        rankings.appendChild(newRow);

        // Add hidden inputs to the form for submission
        const scoresForm = document.getElementById('scores-form');
        const nameInput = document.createElement('input');
        nameInput.type = 'hidden';
        nameInput.name = `new_members[${teammateCount}][name]`;
        nameInput.value = name;

        const scoreInput = document.createElement('input');
        scoreInput.type = 'hidden';
        scoreInput.name = `new_members[${teammateCount}][score]`;
        scoreInput.value = score;

        scoresForm.appendChild(nameInput);
        scoresForm.appendChild(scoreInput);

        // Clear the input fields
        document.getElementById('new_teammate_name').value = '';
        document.getElementById('new_teammate_score').value = '';

        teammateCount++;
        sortRankings();
    });

    // Remove teammate from the rankings and form
    function removeTeammate(id) {
        const row = document.querySelector(`tr[data-id="${id}"]`);
        if (row) row.remove();

        const scoresForm = document.getElementById('scores-form');
        const nameInput = scoresForm.querySelector(`input[name="new_members[${id}][name]"]`);
        const scoreInput = scoresForm.querySelector(`input[name="new_members[${id}][score]"]`);
        if (nameInput) nameInput.remove();
        if (scoreInput) scoreInput.remove();

        teammateCount--;
        sortRankings();
    }

    // Function to sort rankings by score (lowest to highest)
    function sortRankings() {
        const rankings = document.getElementById('rankings');
        const rows = Array.from(rankings.querySelectorAll('tr'));

        rows.forEach(row => {
            const scoreCell = row.querySelector('[id^="score_display_"]');
            const score = parseInt(scoreCell.textContent) || 0;
            row.setAttribute('data-score', score);
        });

        rows.sort((a, b) => {
            const scoreA = parseInt(a.getAttribute('data-score')) || 0;
            const scoreB = parseInt(b.getAttribute('data-score')) || 0;
            return scoreA - scoreB;
        });

        rows.forEach(row => rankings.appendChild(row));
    }
</script>
