<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Printers</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            position: "top-end",
            title: 'Success!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1000
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            position: "top-end",
            title: 'Error!',
            text: '{{ session('error') }}',
            showConfirmButton: true,
        });
    </script>
    @endif

    <form method='POST' action="{{ route('print-test') }}">
        @csrf
        <div class="mb-3 col-md-12">
            <label class="form-label">Select Printer</label>
            <select name="printer_name" class="form-control border border-2 p-2" required>
                @foreach($printers as $printer)
                <option value="{{ $printer }}">{{ $printer }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn bg-gradient-dark">Print Test Page</button>
    </form>
</body>
</html>
