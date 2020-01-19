pipeline {
    agent any

    stages {
        stage('Prepare - install dependencies, copy default config') {
            steps {
                sh 'cp .env.example .env'
                sh 'composer install'
                sh 'rm -rf build/logs'
                sh 'mkdir build/logs'
            }
        }
        stage('PHP Syntax check') { steps { sh 'vendor/bin/parallel-lint --exclude vendor/ .' } }
        stage('Test'){
            steps {
                sh 'vendor/bin/phpunit -c phpunit.xml || exit 0'
            }
        }
        stage('Checkstyle') {
            steps {
                sh 'vendor/bin/phpcs --report=checkstyle --report-file=`pwd`/build/logs/checkstyle.xml --standard=PSR2 --extensions=php --ignore=autoload.php --ignore=vendor/ . || exit 0'
                checkstyle pattern: 'build/logs/checkstyle.xml'
            }
        }
        stage('Run command') {
            steps {
                sh 'php index.php'
            }
        }
    }
}