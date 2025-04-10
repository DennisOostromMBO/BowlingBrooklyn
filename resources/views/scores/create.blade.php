@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-navbar />

<div class="container mx-auto py-20">
    <h1 class="text-4xl font-bold text-center mb-8">Add Scores</h1>

    <!-- Leader Selection -->
    <form id="leader-form" method="GET" action="{{ route('scores.create') }}" class="mb-4">
        <label for="leader" class="block text-gray-200">Select Leader</label>
        <select id="leader" name="leader" class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg" required>
            <option value="">-- Select Leader --</option>
            @foreach($reservations as $reservation)
                <option value="{{ $reservation->id }}" {{ request('leader') == $reservation->id ? 'selected' : '' }}>{{ $reservation->user_name }}</option>
            @endforeach
        </select>
        <button type="submit" class="create bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mt-4">Next</button>
    </form>

    @if(request('leader'))
        <div class="flex flex-col md:flex-row">
            <!-- Score Input for Each Person -->
            <form id="scores-form" method="POST" action="{{ route('scores.store') }}" class="bg-gray-800 p-6 rounded-lg shadow-lg w-full md:w-1/2">
                @csrf
                <input type="hidden" name="reservation_id" value="{{ request('leader') }}">

                <h2 class="text-2xl font-bold text-center mb-4">Enter Scores for Team {{ $leaderName }}</h2>

                <!-- Add team name field -->
                <div class="mb-4">
                    <label for="team_name" class="block text-gray-200">Team Name</label>
                    <input type="text" id="team_name" name="team_name" class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg" placeholder="Enter a team name" value="{{ $leaderName ? $leaderName . '\'s Team' : '' }}">
                    <p class="text-sm text-gray-400">Leave blank to use the default name</p>
                </div>

                @foreach($participants as $participant)
                    <div class="mb-4">
                        <label for="score_{{ $participant->id }}" class="block text-gray-200">{{ $participant->name }}</label>
                        <input type="number" id="score_{{ $participant->id }}" name="scores[{{ $participant->id }}]" class="score-input w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg" required min="0">
                        <input type="hidden" name="participant_names[{{ $participant->id }}]" value="{{ $participant->name }}">
                    </div>
                @endforeach

                <!-- Add Team Members Dynamically -->
                <div id="team-members">
                    <h3 class="text-xl font-bold text-center mb-4">Add Team Members</h3>
                    <div class="mb-4">
                        <label for="new_member_name" class="block text-gray-200">Name</label>
                        <input type="text" id="new_member_name" class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label for="new_member_score" class="block text-gray-200">Score</label>
                        <input type="number" id="new_member_score" class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg" min="0">
                    </div>
                    <button type="button" id="add-member" class="create bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Add Member</button>
                </div>

                <button type="submit" class="create mt-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Save Game</button>
            </form>

            <!-- Live Rankings -->
            <div class="w-full md:w-1/2 md:ml-4 mt-4 md:mt-0">
                <h2 class="text-2xl font-bold text-center mb-4">Live Rankings</h2>
                <table class="w-full border-collapse bg-gray-800 text-gray-200">
                    <thead>
                        <tr>
                            <th class="border border-gray-700 px-4 py-2">Name</th>
                            <th class="border border-gray-700 px-4 py-2">Score</th>
                            <th class="border border-gray-700 px-4 py-2">Actions</th>
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
    // Update scores in live ranking for registered members
    document.querySelectorAll('.score-input').forEach(input => {
        input.addEventListener('input', () => {
            const id = input.id.split('_')[1];
            document.getElementById(`score_display_${id}`).textContent = input.value || 0;
            sortRankings();
        });
    });

    // Add new member to both form and live rankings
    document.getElementById('add-member').addEventListener('click', () => {
        const name = document.getElementById('new_member_name').value;
        const score = document.getElementById('new_member_score').value;

        if (name && score) {
            const uniqueId = 'new_' + Date.now(); // Generate a unique ID for the new member
            const memberForm = document.getElementById('scores-form');

            // Create hidden inputs for the form submission
            const hiddenNameInput = document.createElement('input');
            hiddenNameInput.type = 'hidden';
            hiddenNameInput.name = `new_members[][name]`;
            hiddenNameInput.value = name;

            const hiddenScoreInput = document.createElement('input');
            hiddenScoreInput.type = 'hidden';
            hiddenScoreInput.name = `new_members[][score]`;
            hiddenScoreInput.value = score;

            // Add hidden inputs to the form
            memberForm.appendChild(hiddenNameInput);
            memberForm.appendChild(hiddenScoreInput);

            // Add member to live rankings
            const rankings = document.getElementById('rankings');
            const newRow = document.createElement('tr');
            newRow.setAttribute('data-id', uniqueId);
            newRow.className = 'added-member';
            newRow.setAttribute('data-score', score);

            // Add name column
            const nameCell = document.createElement('td');
            nameCell.className = 'border border-gray-700 px-4 py-2';
            nameCell.textContent = name;

            // Add score column
            const scoreCell = document.createElement('td');
            scoreCell.className = 'border border-gray-700 px-4 py-2';
            scoreCell.textContent = score;

            // Add delete button column
            const actionCell = document.createElement('td');
            actionCell.className = 'border border-gray-700 px-4 py-2';

            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.className = 'bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded';
            deleteButton.textContent = 'Remove';
            deleteButton.onclick = function() {
                // Remove from the table
                rankings.removeChild(newRow);

                // Remove the hidden inputs from the form
                memberForm.removeChild(hiddenNameInput);
                memberForm.removeChild(hiddenScoreInput);
            };

            actionCell.appendChild(deleteButton);

            // Assemble the row
            newRow.appendChild(nameCell);
            newRow.appendChild(scoreCell);
            newRow.appendChild(actionCell);

            // Add to the table
            rankings.appendChild(newRow);

            // Clear input fields
            document.getElementById('new_member_name').value = '';
            document.getElementById('new_member_score').value = '';

            // Sort the rankings
            sortRankings();
        }
    });

    // Function to sort rankings by score (lowest to highest)
    function sortRankings() {
        const rankings = document.getElementById('rankings');
        const rows = Array.from(rankings.querySelectorAll('tr'));

        // Get scores for all rows (registered + added members)
        rows.forEach(row => {
            if(row.classList.contains('registered-member')) {
                // For registered members, get score from the display cell
                const id = row.getAttribute('data-id');
                const scoreCell = document.getElementById(`score_display_${id}`);
                const score = parseInt(scoreCell.textContent) || 0;
                row.setAttribute('data-score', score);
            }
            // Added members already have data-score set
        });

        // Sort rows by score (lowest to highest)
        rows.sort((a, b) => {
            const scoreA = parseInt(a.getAttribute('data-score')) || 0;
            const scoreB = parseInt(b.getAttribute('data-score')) || 0;
            return scoreA - scoreB;
        });

        // Reorder the rows
        rows.forEach(row => {
            rankings.appendChild(row);
        });
    }
</script>
