// Admin entry: import admin-specific styles so Vite bundles them into manifest
import '../css/admin.css';

// Bundle Chart.js via npm (we'll import the module) and fetch monthly data from server
import Chart from 'chart.js/auto';

function createChart(canvas, monthlyData) {
	return new Chart(canvas, {
		type: 'line',
		data: {
			labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
			datasets: [{
				label: 'Requests',
				backgroundColor: 'rgba(59,130,246,0.15)',
				borderColor: 'rgba(59,130,246,1)',
				data: monthlyData,
				fill: true,
				tension: 0.35,
			}]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			plugins: { legend: { display: false } },
			scales: { y: { beginAtZero: true } }
		}
	});
}

function createDocumentsChart(canvas, documentsData) {
	const labels = Object.keys(documentsData);
	const data = Object.values(documentsData);
	
	return new Chart(canvas, {
		type: 'bar',
		data: {
			labels: labels,
			datasets: [{
				label: 'Number of Requests',
				backgroundColor: [
					'rgba(255, 107, 53, 0.7)',
					'rgba(59, 130, 246, 0.7)',
					'rgba(34, 197, 94, 0.7)',
					'rgba(168, 85, 247, 0.7)',
					'rgba(249, 115, 22, 0.7)',
				],
				borderColor: [
					'rgba(255, 107, 53, 1)',
					'rgba(59, 130, 246, 1)',
					'rgba(34, 197, 94, 1)',
					'rgba(168, 85, 247, 1)',
					'rgba(249, 115, 22, 1)',
				],
				borderWidth: 1,
				data: data,
			}]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			plugins: { legend: { display: true } },
			scales: { y: { beginAtZero: true } }
		}
	});
}

document.addEventListener('DOMContentLoaded', function () {
	// Create monthly requests chart
	const canvas = document.getElementById('requestsChart');
	if (canvas) {
		fetch('/api/dashboard/monthly-requests')
			.then(res => res.json())
			.then(json => {
				const monthly = Array.isArray(json.monthly) ? json.monthly : [];
				createChart(canvas, monthly);
			})
			.catch(err => {
				console.error('Failed to load monthly requests data', err);
				// Fallback: show an empty chart
				createChart(canvas, [0,0,0,0,0,0,0,0,0,0,0,0]);
			});
	}

	// Create documents chart if data is available
	const documentsCanvas = document.getElementById('documentsChart');
	if (documentsCanvas && window.mostRequestedDocuments) {
		createDocumentsChart(documentsCanvas, window.mostRequestedDocuments);
	}

	// Sidebar toggle for small screens
	const toggle = document.getElementById('sidebarToggle');
	if (toggle) {
		toggle.addEventListener('click', function () {
			document.body.classList.toggle('sidebar-open');
		});
	}
});

