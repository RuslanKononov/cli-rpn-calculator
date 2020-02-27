# cli-rpn-calculator
CLI reverse polish notation (RPN) calculator

## Run Application

1. checkout to project directory and update dependencies via composer

2. run console application

    ```sh
    $ php bin/console app:rpn-calculator
    ```
3. input arguments and operations to cli, for example:

    ```sh
    $ 5 8 3 + -
    ```
    or 
     ```sh
    $ 5 8 3
    $ + -
    ```
    or 
     ```sh
    $ 5
    $ 8
    $ 3
    $ +
    $ -
    ```
    and so on.
    
  Calculation will execude in reverse mode:
  
```
    8 + 3 = 11
    5 - 11 = -6
```
  Currently you can use standard operations ```('+', '-', '*', '/')``` But it will modernize in future... Maybe ;-)
  
Hope you'll take fun! 
