# Sorting Visualizer

This application enables the visualization of data from CSV files which have sorted data.

## Technical Explanation
The Sorting Visualizer app consists of two endpoints:

```
/generate/visualizer
```
This endpoint generates ordered data from the CSV file, making it ready for sharing.
```
/{id}
```
This is the main endpoint, allows the visualization of shared data by utilizing the Sorting entity's unique identifier (ID). The ID in the URL is optional.

I have adhered to the principles of Domain-Driven Design (DDD) and have created comprehensive tests for the application.

## Installation Guide
To install the Sorting Visualizer, execute the following command:

```
make install
```

## Running Tests
To run all tests for the application, use the following command:

```
make test-all
```


Feel free to reach out if you have any questions :D