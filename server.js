import { spawn } from 'child_process';
import path from 'path';

// Use environment variable for port or default to 8080
const PORT = process.env.PORT || 8080;

console.log(`Starting server on port ${PORT}`);

// Start Laravel's built-in server
const server = spawn('php', [
  'artisan',
  'serve',
  `--host=0.0.0.0`,
  `--port=${PORT}`
], {
  stdio: 'inherit'
});

// Handle server process events
server.on('error', (err) => {
  console.error('Failed to start server:', err);
  process.exit(1);
});

server.on('close', (code) => {
  console.log(`Server process exited with code ${code}`);
  process.exit(code);
});

// Handle termination signals
process.on('SIGINT', () => {
  console.log('Received SIGINT, shutting down server');
  server.kill('SIGINT');
});

process.on('SIGTERM', () => {
  console.log('Received SIGTERM, shutting down server');
  server.kill('SIGTERM');
}); 