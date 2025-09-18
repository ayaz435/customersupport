<form action="{{ route('zoom-meetings.store') }}" method="post">
    @csrf
    <label for="topic">Meeting Topic:</label>
    <input type="text" name="topic" id="topic" required>
    <br>
    <label for="start_time">Meeting Start Time:</label>
    <input type="datetime-local" name="start_time" id="start_time" required>
    <br>
    <button type="submit">Create Zoom Meeting</button>
</form>
