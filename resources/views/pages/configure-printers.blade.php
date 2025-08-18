<!-- jQuery and SweetAlert2 -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <div class="container mt-5">
        <h3>Configure Printers</h3>
        <!-- IP Discovery Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Find Printer IP</h5>
            </div>
            <div class="card-body">
                <button id="scanNetwork" class="btn btn-info">Scan Network for Printers</button>
                <div id="scanResults" class="mt-3"></div>
            </div>
        </div>
        <!-- Add Printer Form -->
        <form method="POST" action="{{ route('add-printer') }}" class="row">
            @csrf
            <div class="col-md-6 mb-3">
                <input name="name" class="form-control" placeholder="Printer Name" required>
            </div>
            <div class="col-md-6 mb-3">
                <button type="submit" class="btn btn-primary">Save Printer</button>
            </div>
        </form>

        <hr>


        <script>
document.getElementById('scanNetwork').addEventListener('click', function () {
    const resultsDiv = document.getElementById('scanResults');
    resultsDiv.innerHTML = 'Sending test print...';

    fetch("{{ route('test-print') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({})
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            resultsDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
        } else {
            resultsDiv.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
    })
    .catch(err => {
        resultsDiv.innerHTML = `<div class="alert alert-danger">Error: ${err.message}</div>`;
    });
});
</script>


        <!-- Saved Printers List -->
        <h5>Saved Printers</h5>
        @foreach($printers as $printer)
            <div class="card mb-2 p-2 d-flex flex-row justify-content-between align-items-center">
                <div>
                    <strong>{{ $printer->name }}</strong> — {{ $printer->ip }}
                </div>
                <div>
                    <button class="btn btn-sm btn-success connect-print" data-ip="{{ $printer->ip }}">
                        Connect & Print Test
                    </button>
                </div>
            </div>
        @endforeach

        <!-- Status Display -->
        <div class="mt-4">
            <h6>Status:</h6>
            <div id="printerStatus" class="alert alert-secondary">Not connected</div>
        </div>
    </div>

    @push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Network scanner
            document.getElementById('scanNetwork').addEventListener('click', () => {
                const results = document.getElementById('scanResults');
                results.innerHTML = '<div class="alert alert-info">Scanning network...</div>';
                
                // Check common printer IPs
                const commonIPs = ['192.168.1.100', '192.168.1.200', '192.168.0.100', '192.168.0.200'];
                let foundPrinters = [];
                
                commonIPs.forEach(ip => {
                    fetch(`http://${ip}:8080/status`, { method: 'GET', mode: 'no-cors' })
                        .then(() => {
                            foundPrinters.push(ip);
                            updateScanResults(foundPrinters);
                        })
                        .catch(() => {});
                });
                
                setTimeout(() => {
                    if (foundPrinters.length === 0) {
                        results.innerHTML = '<div class="alert alert-warning">No printers found. Enter IP manually.</div>';
                    }
                }, 3000);
            });
            
            function updateScanResults(ips) {
                const results = document.getElementById('scanResults');
                let html = '<div class="alert alert-success">Found printers:</div>';
                ips.forEach(ip => {
                    html += `<div class="card mb-2 p-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span><strong>${ip}</strong></span>
                            <button class="btn btn-sm btn-primary use-ip" data-ip="${ip}">Use This IP</button>
                        </div>
                    </div>`;
                });
                results.innerHTML = html;
                
                document.querySelectorAll('.use-ip').forEach(btn => {
                    btn.addEventListener('click', () => {
                        document.querySelector('input[name="ip"]').value = btn.dataset.ip;
                    });
                });
            }
            
            document.querySelectorAll('.connect-print').forEach(btn => {
                btn.addEventListener('click', () => {
                    const ip = btn.dataset.ip;
                    const status = document.getElementById('printerStatus');
                    status.textContent = 'Connecting...';
                    status.className = 'alert alert-info';

                    // Test connection with fetch first
                    fetch(`http://${ip}:8080/status`, {
                        method: 'GET',
                        mode: 'cors'
                    })
                    .then(response => {
                        if (response.ok) {
                            status.textContent = 'Connected to ' + ip;
                            status.className = 'alert alert-success';
                            
                            // Send print command
                            return fetch(`http://${ip}:8080/print`, {
                                method: 'POST',
                                headers: {'Content-Type': 'application/json'},
                                body: JSON.stringify({
                                    text: '*** Test Page ***\nHello, HS‑88AI via Laravel!\n\n'
                                })
                            });
                        } else {
                            throw new Error('Printer not responding');
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            status.textContent = 'Print job sent successfully!';
                            status.className = 'alert alert-success';
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        status.textContent = 'Error: ' + (err.message || 'Connection failed');
                        status.className = 'alert alert-danger';
                    });
                });
            });
        });
    </script>
    @endpush

</x-layout>
