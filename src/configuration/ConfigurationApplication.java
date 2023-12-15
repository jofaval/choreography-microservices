package com.capgemini.choreography_microservices.configuration;

import java.io.IOException;
import java.io.OutputStream;
import java.net.InetSocketAddress;

import com.sun.net.httpserver.HttpExchange;
import com.sun.net.httpserver.HttpHandler;
import com.sun.net.httpserver.HttpServer;

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

    private setData(HashMap<String, String> dotEnvData) {
        this.dotEnvData = dotEnvData;
    }

    private void read(String file) {
        HashMap<String, String> dotEnvData = new HashMap<String, String>();

        throw new Exception("not implemented");

        return this.setData(dotEnvData)
    }

    public String getByKey(String key) {
        if (!this.getData()) {
            this.read();
        }

        return this.getData().get(key);
    }
}

public class ConfigurationApplication {
    public static void main(String[] args) throws Exception {
        HttpServer server = HttpServer.create(new InetSocketAddress(8000), 0);
        server.createContext("/test", new MyHandler());
        server.setExecutor(null); // creates a default executor
        server.start();
    }

    static class MyHandler implements HttpHandler {
        @Override
        public void handle(HttpExchange t) throws IOException {
            String response = "This is the response";
            t.sendResponseHeaders(200, response.length());
            OutputStream os = t.getResponseBody();
            os.write(response.getBytes());
            os.close();
        }
    }
}