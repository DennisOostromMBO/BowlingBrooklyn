@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-navbar />

<div class="container mx-auto py-20">
    <h1 class="text-4xl font-bold text-center mb-8">Edit Score</h1>

    <form action="{{ route('scores.update', $score->id) }}" method="POST" class="bg-gray-800 p-6 rounded-lg shadow-lg">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="team_name" class="block text-gray-200">Team Name</label>
            <input type="text" id="team_name" name="team_name" value="{{ $score->team_name }}" class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="round" class="block text-gray-200">Round</label>
            <input type="number" id="round" name="round" value="{{ $score->round }}" class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg" required>
        </div>
        <div class="mb-4">
            <label for="status" class="block text-gray-200">Status</label>
            <select id="status" name="status" class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg">
                <option value="In progress" {{ $score->status == 'In progress' ? 'selected' : '' }}>In progress</option>
                <option value="Confirmed" {{ $score->status == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="isactive" class="block text-gray-200">Active</label>
            <select id="isactive" name="isactive" class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg">
                <option value="1" {{ $score->isactive == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ $score->isactive == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="note" class="block text-gray-200">Note</label>
            <textarea id="note" name="note" class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg">{{ $score->note }}</textarea>
        </div>
        
        <!-- Team Members -->
        <h3 class="text-xl font-bold mb-4">Team Members</h3>
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
                                    value="{{ $teammate['name'] }}" 
                                    class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg">
                            </td>
                            <td class="border border-gray-700 px-4 py-2">
                                <input type="number" name="teammate{{ $teammate['index'] }}_score" 
                                    value="{{ $teammate['score'] }}" 
                                    class="teammate-score w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg"
                                    min="0">
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
        
        <!-- Add new team member (if team has less than 8 members) -->
        @if(count($teammates) < 8)
            <div class="mb-4 bg-gray-700 p-4 rounded">
                <h4 class="text-lg font-bold mb-2">Add New Team Member</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="new_teammate_name" class="block text-gray-200">Name</label>
                        <input type="text" id="new_teammate_name" class="w-full px-4 py-2 bg-gray-600 text-gray-200 rounded-lg">
                    </div>
                    <div>
                        <label for="new_teammate_score" class="block text-gray-200">Score</label>
                        <input type="number" id="new_teammate_score" class="w-full px-4 py-2 bg-gray-600 text-gray-200 rounded-lg" min="0">
                    </div>
                </div>
                <button type="button" id="add-teammate" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-4 rounded mt-2">
                    Add Member
                </button>
            </div>
        @endif
        
        <input type="hidden" name="points" id="total_points" value="{{ $score->points }}">
        
        <button type="submit" class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded">Save Changes</button>
        <a href="{{ route('scores.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded ml-2">Cancel</a>
    </form>
</div>

<x-footer />

<script>
    // Track next available index for new members
    let nextAvailableIndex = {{ count($teammates) + 1 }};
    
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
            const name = document.getElementById('new_teammate_name').value;
            const score = document.getElementById('new_teammate_score').value;
            
            if (!name || !score) {
                alert('Please enter both name and score');
                return;
            }
            
            if (nextAvailableIndex > 8) {
                alert('Maximum 8 team members allowed');
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
                        class="w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg">
                </td>
                <td class="border border-gray-700 px-4 py-2">
                    <input type="number" name="teammate${nextAvailableIndex}_score" 
                        value="${score}" 
                        class="teammate-score w-full px-4 py-2 bg-gray-700 text-gray-200 rounded-lg"
                        min="0">
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
                updateTotalPoints();
                
                // Check if we need to show the add member section again
                if (document.querySelectorAll('.teammate-row').length < 8 && !document.getElementById('add-teammate')) {
                    location.reload(); // Simple way to show the add section again
                }
            });
            
            // Increment index for next member
            nextAvailableIndex++;
            
            // Update total points
            updateTotalPoints();
            
            // Sort the rows
            sortTeammateRows();
            
            // Hide add member section if we've reached 8 members
            if (nextAvailableIndex > 8) {
                document.querySelector('.bg-gray-700.p-4.rounded').style.display = 'none';
            }
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
            updateTotalPoints();
            
            // Check if we need to show the add member section again
            if (document.querySelectorAll('.teammate-row').length < 8 && !document.getElementById('add-teammate')) {
                location.reload(); // Simple way to show the add section again
            }
        });
    });
    
    // Calculate initial total points
    updateTotalPoints();
</script>
