#include "../include/command_executor.h"
#include <boost/process.hpp>
#include <boost/date_time/posix_time/posix_time.hpp>
#include <fstream>
#include <iostream>

CommandExecutor::CommandExecutor(const std::string &logFilePath) : logFilePath(logFilePath) {}

void CommandExecutor::executeCommand(const std::string &command, const std::vector<std::string> &args) {
    try {
        boost::process::ipstream outStream;
        boost::process::child c(command, boost::process::args(args), boost::process::std_out > outStream);

        std::string line;
        while (outStream && std::getline(outStream, line) && !line.empty()) {
            std::cout << line << std::endl;
        }

        c.wait();
        int result = c.exit_code();
        if (result != 0) {
            logError("Command failed with exit code: " + std::to_string(result));
        }
    } catch (const std::exception &e) {
        logError(e.what());
    }
}

void CommandExecutor::logError(const std::string &errorMessage) {
    std::ofstream logFile;
    logFile.open(logFilePath, std::ios_base::app);
    if (logFile.is_open()) {
        logFile << getCurrentDateTime() << " - ERROR: " << errorMessage << std::endl;
        logFile.close();
    } else {
        std::cerr << "Failed to open log file: " << logFilePath << std::endl;
    }
}

std::string CommandExecutor::getCurrentDateTime() {
    auto now = boost::posix_time::second_clock::local_time();
    return boost::posix_time::to_simple_string(now);
}

