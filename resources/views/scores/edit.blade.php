@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-navbar />

<div class="container mx-auto py-20">
    <h1 class="text-4xl font-bold text-center mb-8">Edit Score</h1>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
            <h3 class="font-bold mb-2">There were some errors:</h3>
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

    <!-- Team Member Counter Display -->
    <div id="team-member-counter" class="text-center mb-4">
        <p class="text-lg font-semibold">
            Team Members: <span id="current-member-count">0</span> / <span class="max-members">8</span>
        </p>
        <div class="w-full bg-gray-300 rounded-full h-2.5">
            <div id="member-progress-bar" class="bg-blue-600 h-2.5 rounded-full" style="width: 0%"></div>
        </div>
    </div>

    <form action="{{ route('scores.update', $score->id) }}" method="POST" class="bg-gray-800 p-6 rounded-lg shadow-lg" onsubmit="return validateForm()">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="team_name" class="block text-gray-200">Team Name</label>
            <input type="text" id="team_name" name="team_name" value="{{ old('team_name', $score->team_name) }}" class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="round" class="block text-gray-200">Round</label>
            <input type="number" id="round" name="round" value="{{ old('round', $score->round) }}" class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="status" class="block text-gray-200">Status</label>
            <select id="status" name="status" class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg">
                <option value="In progress" {{ old('status', $score->status) == 'In progress' ? 'selected' : '' }}>In progress</option>
                <option value="Confirmed" {{ old('status', $score->status) == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
            </select>
            <p class="text-sm text-yellow-500 mt-1">Note: Once confirmed, the score cannot be edited or deleted.</p>
        </div>
        <div class="mb-4">
            <label for="isactive" class="block text-gray-200">Active</label>
            <select id="isactive" name="isactive" class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg">
                <option value="1" {{ old('isactive', $score->isactive) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('isactive', $score->isactive) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="note" class="block text-gray-200">Note</label>
            <textarea id="note" name="note" class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg">{{ old('note', $score->note) }}</textarea>
        </div>

        <!-- Team Members -->
        <h3 class="text-xl font-bold mb-4">Team Members</h3>
        <p class="text-sm text-gray-400 mb-2">Note: A maximum of 8 team members can be entered.</p>
        <div class="grid grid-cols-1 gap-4">
            <table class="w-full border-collapse bg-gray-800 text-gray-200 mb-4">
                <thead>
                    <tr>
                        <th class="border border-gray-700 px-4 py-2">Name</th>
                        <th class="border border-gray-700 px-4 py-2">Score</th>
                        <th class="border border-gray-700 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody id="teammates-table">
                    @php
                        $teammates = [];
                        for ($i = 1; $i <= 8; $i++) {
                            if($score->{"teammate$i"}) {
                                $teammates[] = [
                                    'name' => $score->{"teammate$i"},
                                    'score' => $score->{"teammate{$i}_score"},
                                    'index' => $i
                                ];
                            }
                        }
                        // Sort teammates by score (lowest to highest)
                        usort($teammates, function($a, $b) {
                            return $a['score'] - $b['score'];
                        });
                    @endphp

                    @foreach($teammates as $teammate)
                        <tr class="teammate-row" data-index="{{ $teammate['index'] }}">
                            <td class="border border-gray-700 px-4 py-2">
                                <input type="text" name="teammate{{ $teammate['index'] }}"
                                    value="{{ old("teammate{$teammate['index']}", $teammate['name']) }}"
                                    class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg teammate-name-input" required>
                            </td>
                            <td class="border border-gray-700 px-4 py-2">
                                <input type="number" name="teammate{{ $teammate['index'] }}_score"
                                    value="{{ old("teammate{$teammate['index']}_score", $teammate['score']) }}"
                                    class="teammate-score w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg"
                                    min="0" max="300" required>
                            </td>
                            <td class="border border-gray-700 px-4 py-2">
                                <button type="button" class="remove-teammate bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded">
                                    Remove
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Add new team member -->
        <div id="add-member-section" class="mb-4 bg-gray-700 p-4 rounded {{ count($teammates) >= 8 ? 'hidden' : '' }}">
            <h4 class="text-lg font-bold mb-2">Add New Team Member</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="new_teammate_name" class="block text-gray-200">Name</label>
                    <input type="text" id="new_teammate_name" class="w-full px-4 py-2 bg-gray-600 text-gray-200 rounded-lg">
                </div>
                <div>
                    <label for="new_teammate_score" class="block text-gray-200">Score</label>
                    <input type="number" id="new_teammate_score" class="w-full px-4 py-2 bg-gray-600 text-gray-200 rounded-lg" min="0" max="300">
                </div>
            </div>
            <button type="button" id="add-teammate" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-4 rounded mt-2">
                Add
            </button>
            <p id="max-members-warning" class="text-red-500 mt-2 hidden">Maximum of 8 team members reached!</p>
        </div>

        <input type="hidden" name="points" id="total_points" value="{{ $score->points }}">

        <div class="mt-6 flex justify-between">
            <a href="{{ route('scores.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Cancel</a>
            <button type="submit" class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded">Save Changes</button>
        </div>
    </form>
</div>

<x-footer />

<script>
    // Constants
    const MAX_TEAMMATES = 8;

    // Track next available index for new members
    let nextAvailableIndex = {{ count($teammates) + 1 }};
    let currentTeammateCount = {{ count($teammates) }};

    // Form validation
    function validateForm() {
        let isValid = true;

        // Validate teammate name fields
        document.querySelectorAll('.teammate-name-input').forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('border-red-500');

                // Add error message if not exists
                if (!input.nextElementSibling || !input.nextElementSibling.classList.contains('error-message')) {
                    const errorMsg = document.createElement('p');
                    errorMsg.className = 'text-red-500 text-sm mt-1 error-message';
                    errorMsg.textContent = 'Name is required';
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

        // Validate teammate score fields
        document.querySelectorAll('.teammate-score').forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('border-red-500');

                // Add error message if not exists
                if (!input.nextElementSibling || !input.nextElementSibling.classList.contains('error-message')) {
                    const errorMsg = document.createElement('p');
                    errorMsg.className = 'text-red-500 text-sm mt-1 error-message';
                    errorMsg.textContent = 'Score is required';
                    input.parentNode.insertBefore(errorMsg, input.nextSibling);
                }
            } else if (parseInt(input.value) < 0 || parseInt(input.value) > 300) {
                isValid = false;
                input.classList.add('border-red-500');

                // Add error message if not exists
                if (!input.nextElementSibling || !input.nextElementSibling.classList.contains('error-message')) {
                    const errorMsg = document.createElement('p');
                    errorMsg.className = 'text-red-500 text-sm mt-1 error-message';
                    errorMsg.textContent = 'Score must be between 0 and 300';
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

        return isValid;
    }

    // Update member counter and progress bar
    function updateMemberCounter() {
        const counterElement = document.getElementById('current-member-count');
        const progressBar = document.getElementById('member-progress-bar');

        if (counterElement && progressBar) {
            counterElement.textContent = currentTeammateCount;
            const percentage = (currentTeammateCount / MAX_TEAMMATES) * 100;
            progressBar.style.width = `${percentage}%`;

            // Change color as it gets closer to max
            if (currentTeammateCount >= MAX_TEAMMATES) {
                progressBar.classList.remove('bg-blue-600', 'bg-yellow-500');
                progressBar.classList.add('bg-red-600');
            } else if (currentTeammateCount >= 6) {
                progressBar.classList.remove('bg-blue-600', 'bg-red-600');
                progressBar.classList.add('bg-yellow-500');
            } else {
                progressBar.classList.remove('bg-yellow-500', 'bg-red-600');
                progressBar.classList.add('bg-blue-600');
            }
        }

        // Show/hide the add member section based on the count
        const addMemberSection = document.getElementById('add-member-section');
        if (addMemberSection) {
            if (currentTeammateCount >= MAX_TEAMMATES) {
                addMemberSection.classList.add('hidden');
                if (document.getElementById('max-members-warning')) {
                    document.getElementById('max-members-warning').classList.remove('hidden');
                }
            } else {
                addMemberSection.classList.remove('hidden');
                if (document.getElementById('max-members-warning')) {
                    document.getElementById('max-members-warning').classList.add('hidden');
                }
            }
        }
    }

    // Function to recalculate total points
    function updateTotalPoints() {
        let total = 0;
        document.querySelectorAll('.teammate-score').forEach(input => {
            total += parseInt(input.value) || 0;
        });
        document.getElementById('total_points').value = total;
    }

    // Function to sort teammates by score (lowest to highest)
    function sortTeammateRows() {
        const tbody = document.getElementById('teammates-table');
        const rows = Array.from(tbody.querySelectorAll('.teammate-row'));

        // Get scores for all rows
        rows.forEach(row => {
            const scoreInput = row.querySelector('.teammate-score');
            row.setAttribute('data-score', scoreInput.value || 0);
        });

        // Sort rows by score (lowest to highest)
        rows.sort((a, b) => {
            return parseInt(a.getAttribute('data-score')) - parseInt(b.getAttribute('data-score'));
        });

        // Reorder rows
        rows.forEach(row => {
            tbody.appendChild(row);
        });
    }

    // Add event listeners to existing score inputs
    document.querySelectorAll('.teammate-score').forEach(input => {
        input.addEventListener('input', () => {
            updateTotalPoints();
            sortTeammateRows();
        });
    });

    // Add new team member
    const addTeammateBtn = document.getElementById('add-teammate');
    if (addTeammateBtn) {
        addTeammateBtn.addEventListener('click', function() {
            const name = document.getElementById('new_teammate_name').value.trim();
            const score = document.getElementById('new_teammate_score').value;

            if (!name || !score) {
                alert('Both fields are required for a new team member.');
                return;
            }

            if (currentTeammateCount >= MAX_TEAMMATES) {
                document.getElementById('max-members-warning').classList.remove('hidden');
                return;
            }

            const tbody = document.getElementById('teammates-table');
            const row = document.createElement('tr');
            row.className = 'teammate-row';
            row.setAttribute('data-index', nextAvailableIndex);
            row.setAttribute('data-score', score);

            row.innerHTML = `
                <td class="border border-gray-700 px-4 py-2">
                    <input type="text" name="teammate${nextAvailableIndex}"
                        value="${name}"
                        class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg teammate-name-input" required>
                </td>
                <td class="border border-gray-700 px-4 py-2">
                    <input type="number" name="teammate${nextAvailableIndex}_score"
                        value="${score}"
                        class="teammate-score w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg"
                        min="0" max="300" required>
                </td>
                <td class="border border-gray-700 px-4 py-2">
                    <button type="button" class="remove-teammate bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded">
                        Remove
                    </button>
                </td>
            `;

            tbody.appendChild(row);

            // Clear inputs
            document.getElementById('new_teammate_name').value = '';
            document.getElementById('new_teammate_score').value = '';

            // Add event listener to new score input
            const scoreInput = row.querySelector('.teammate-score');
            scoreInput.addEventListener('input', function() {
                updateTotalPoints();
                sortTeammateRows();
                row.setAttribute('data-score', this.value || 0);
            });

            // Add event listener to remove button
            const removeBtn = row.querySelector('.remove-teammate');
            removeBtn.addEventListener('click', function() {
                row.remove();
                currentTeammateCount--;
                updateTotalPoints();
                updateMemberCounter();
            });

            // Increment counters
            nextAvailableIndex++;
            currentTeammateCount++;

            // Update total points and UI
            updateTotalPoints();
            sortTeammateRows();
            updateMemberCounter();
        });
    }

    // Remove existing team member
    document.querySelectorAll('.remove-teammate').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.closest('.teammate-row');
            const index = row.getAttribute('data-index');

            // Add hidden input to indicate removal
            const form = this.closest('form');
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = `remove_teammate[${index}]`;
            hiddenInput.value = '1';
            form.appendChild(hiddenInput);

            // Remove row from table
            row.remove();

            // Update counts
            currentTeammateCount--;
            updateTotalPoints();
            updateMemberCounter();
        });
    });

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateTotalPoints();
        updateMemberCounter();
    });
</script>
