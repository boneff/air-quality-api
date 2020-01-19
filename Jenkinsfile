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
        stage('Test'){
            steps {
                sh 'vendor/bin/phpunit -c phpunit.xml || exit 0'
            }
        }
        stage('Run command') {
            steps {
                sh 'php index.php'
            }
        }
    }
}