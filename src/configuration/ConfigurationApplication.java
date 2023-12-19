package com.capgemini.choreography_microservices.configuration;

import java.io.IOException;
import java.io.OutputStream;
import java.net.InetSocketAddress;

import com.sun.net.httpserver.HttpExchange;
import com.sun.net.httpserver.HttpHandler;
import com.sun.net.httpserver.HttpServer;

import java.io.*;
import java.net.ServerSocket;
import java.net.Socket;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.ArrayList;
import java.util.List;

// https://stackoverflow.com/questions/3732109/simple-http-server-in-java-using-only-java-se-api

public class DotEnvFlashReader {
    private static DotEnvFlashReader instance;
    private HashMap<String, String> dotEnvData;

    public static DotEnvFlashReader getInstance() {
        if (DotEnvFlashReader.instance == null) {
            DotEnvFlashReader reader = new DotEnvFlashReader();
            reader.read();
        }

        return DotEnvFlashReader.instance;
    }

    public HashMap<String, String> getData() {
        return this.dotEnvData;
    }

    private setData(HashMap<String, String> _dotEnvData) {
        this.dotEnvData = _dotEnvData;
    }

    private void read(String file) {
        HashMap<String, String> _dotEnvData = new HashMap<String, String>();

        throw new Exception("not implemented");

        return this.setData(_dotEnvData)
    }

    public String getByKey(String key) {
        if (!this.getData()) {
            this.read();
        }

        return this.getData().get(key);
    }
}

public class HttpHeaders {
    private List<String> headers;
    private static HEADERS_START_LINE = 2;

    public setHeaders(List<String> headers) {
        this.headers = headers;
    }

    public List<String> getHeaders() {
        return this.headers;
    }

    static HttpHeaders parse(String request) {
        String[] requestsLines = request.split("\r\n");
        
        List<String> headers = new ArrayList<>();
        for (int headerIndex = HttpHeaders.HEADERS_START_LINE; headerIndex < requestsLines.length; headerIndex++) {
            headers.add(requestsLines[headerIndex]);
        }

        HttpHeaders instance = new HttpHeaders();
        instance.setHeaders(headers);
        return instance;
    }
}

public class HttpRequest {
    private HttpHeaders headers;
    private String method;
    private String path;
    private String version;
    private String host;

    public HttpHeaders setHeaders(HttpHeaders headers) {
        this.headers = headers;
        return this;
    }

    public HttpHeaders getHeaders()  {
        return this.headers.getHeaders();
    }

    public String setMethod(String method) {
        this.method = method;
        return this;
    }

    public String getMethod()  {
        return this.method;
    }

    public String setPath(String path) {
        this.path = path;
        return this;
    }

    public String getPath()  {
        return this.path;
    }

    public String setVersion(String version) {
        this.version = version;
        return this;
    }

    public String getVersion()  {
        return this.version;
    }

    public String setHost(String host) {
        this.host = host;
        return this;
    }

    public String getHost()  {
        return this.host;
    }

    static HttpRequest parse(String request) {
        HttpRequest request = new HttpRequest();

        String[] requestsLines = request.split("\r\n");
        String[] requestLine = requestsLines[0].split(" ");

        request.setHeaders(HttpHeaders.parse(request))
            .setMethod(requestLine[0])
            .setPath(requestLine[1])
            .setVersion(requestLine[2])
            .setHost(requestsLines[1]
            .split(" ")[1]);

        return request;
    }
}

enum HttpStatus {
    OK = "200 OK"
}

public class ConfigurationApplication {
    private static int getPort(String[] args) {
        // TODO: read from args
        return 8080;
    }

    public static void main(String[] args) throws Exception {
        try (ServerSocket serverSocket = new ServerSocket(ConfigurationApplication.getPort(args))) {
            while (true) {
                try (Socket client = serverSocket.accept()) {
                    handleClient(client);
                }
            }
        }
    }

    protected static void onMessageParsed(HttpRequest request) {
        String accessLog = String.format("Client %s, method %s, path %s, version %s, host %s, headers %s",
                client.toString(), request.getMethod(), request.getPath(), request.getVersion(), request.getHost(), request.getHeaders().toString());
        System.out.println(accessLog);
    }

    private static StringBuilder getRawRequest(Socket client) {
        BufferedReader br = new BufferedReader(new InputStreamReader(client.getInputStream()));

        StringBuilder requestBuilder = new StringBuilder();
        String line;
        while (!(line = br.readLine()).isBlank()) {
            requestBuilder.append(line + "\r\n");
        }

        return requestBuilder;
    }

    private static byte[] getDotEnvParsedContent() {
        // TODO: return here parsed dotenv file
        return "Hello World!!".getBytes();
    }

    private static void handleResponse(Socket client, HttpRequest request) {
        sendResponse(client, HttpStatus.OK, "text/html", ConfigurationApplication.getDotEnvParsedContent());
    }

    private static void handleClient(Socket client) throws IOException {
        StringBuilder requestBuilder = ConfigurationApplication.getRawRequest();

        HttpRequest request = HttpRequest.parse(requestBuilder.toString());
        ConfigurationApplication.onMessageParsed(request);

        ConfigurationApplication.handleResponse(client, request)
    }

    // https://dev.to/mateuszjarzyna/build-your-own-http-server-in-java-in-less-than-one-hour-only-get-method-2k02
    // TODO: add possibility to extract by key
    private static void sendResponse(Socket client, String status, String contentType, byte[] content) throws IOException {
        OutputStream clientOutput = client.getOutputStream();
        clientOutput.write(("HTTP/1.1 \r\n" + status).getBytes());
        clientOutput.write(("ContentType: " + contentType + "\r\n").getBytes());
        clientOutput.write("\r\n".getBytes());
        clientOutput.write(content);
        clientOutput.write("\r\n\r\n".getBytes());
        clientOutput.flush();
        client.close();
    }
}