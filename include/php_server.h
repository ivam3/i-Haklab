// servidor_php.cpp
// Autor: @demon_rip
#pragma once 


#include "below_zero.h"

class PHPServer {
public:
    PHPServer(boost::asio::io_service& io_service, short port, const std::string& domain)
        : io_service_(io_service), acceptor_(io_service, boost::asio::ip::tcp::endpoint(boost::asio::ip::tcp::v4(), port)) {
        domain_ = domain;
        start_accept();
    }

private:
    void start_accept() {
        std::cout << "Server started on domain: " << domain_ << ", port: " << acceptor_.local_endpoint().port() << std::endl;
        ConnectionPtr new_connection(new Connection(io_service_));
        acceptor_.async_accept(new_connection->socket(), std::bind(&PHPServer::handle_accept, this, new_connection, std::placeholders::_1)
            );
    }

    void handle_accept(ConnectionPtr new_connection, const boost::system::error_code& error) {
        if (!error) {
            new_connection->start(domain_);
        }

        start_accept();
    }

    class Connection : public std::enable_shared_from_this<Connection> {
      public:
        Connection(boost::asio::io_service& io_service)
            : socket_(io_service) {}

        boost::asio::ip::tcp::socket& socket() {
            return socket_;
        }

        void start(const std::string& domain) {
            // Aquí puedes implementar la lógica para manejar las solicitudes PHP
            // Por ejemplo, puedes leer la solicitud, ejecutar el código PHP y enviar la respuesta al cliente
            // Ten en cuenta que esto es un servidor muy básico, en un entorno real deberías considerar la seguridad, el rendimiento, etc.
        }

    private:
        boost::asio::ip::tcp::socket socket_;
    };

    boost::asio::io_service& io_service_;
    boost::asio::ip::tcp::acceptor acceptor_;
    std::string domain_;
    typedef std::shared_ptr<Connection> ConnectionPtr;
};



