以下は現在の設定に基づいたREADMEファイルのテンプレートです。必要に応じて調整してください。

MicroAPI PHP Project

This is a simple PHP-based API using Slim framework and React for the frontend. The project includes a basic API endpoint (/api/hello) and Swagger UI for API documentation.

Project Structure

.
├── backend/        # PHP API using Slim Framework
├── frontend/       # React frontend with Swagger UI integration
├── docker-compose.yml  # Docker configuration file

Installation

Requirements

	•	Docker
	•	Docker Compose

Steps to Run

	1.	Clone the repository:

git clone https://github.com/yasuhisa1984/microApi_php.git
cd microApi_php

	2.	Build and start the containers:

docker compose up --build

	3.	Access the API and frontend:

	•	API: http://localhost:8080/api/hello
	•	Swagger UI: http://localhost:3000/swagger.html

API Endpoints

/api/hello

Returns a JSON response with a test message.

Response Example:

{
  "message": "Hello, World! this is test app"
}

CORS Configuration

CORS is enabled in index.php for requests from http://localhost:3000. Modify this configuration as needed for production.

$app->add(function (Request $request, $handler) {
    $response = $handler->handle($request);
    return $response->withHeader('Access-Control-Allow-Origin', 'http://localhost:3000')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization');
});

Troubleshooting

If you encounter CORS errors, ensure that the correct headers are set in both the .htaccess file and the Slim framework middleware. Additionally, make sure Apache is running properly in the backend container using the following commands:

# Restart Apache within the container
docker exec -it <container_name> apachectl restart

Feel free to expand this README to suit the needs of your project!
