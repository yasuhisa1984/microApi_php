window.onload = function() {
  window.ui = SwaggerUIBundle({
    url: "http://localhost:8080/openapi",
    dom_id: '#swagger-ui',
    presets: [
      SwaggerUIBundle.presets.apis,
      SwaggerUIStandalonePreset
    ],
    layout: "StandaloneLayout"
  });
};
