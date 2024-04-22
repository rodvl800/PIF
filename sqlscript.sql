ALTER TABLE Measurement
        ADD FOREIGN KEY (Username)
            REFERENCES users(Username);