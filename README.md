# Carbon Intensity Checker

This Laravel application provides a console command to check the current carbon intensity for a specified zone and displays the corresponding traffic light status (GREEN, YELLOW, or RED) based on the carbon intensity value.

## Installation

Follow these steps to install and set up the Carbon Intensity Checker in your Laravel application.

1. Clone the Repository
2. Install Dependencies
```php
composer install
```
3. Set Up Environment Variables
```php
cp .env.example .env
```
Then, generate an application key:
```php
php artisan key:generate
```
4. Configure API Credentials
The application uses the Electricity Maps API to fetch carbon intensity data.
Add the following variables to your .env file:
```php
ELECTRICITY_MAPS_BASE_URL=https://api.electricitymap.org
ELECTRICITY_MAPS_API_TOKEN=your_api_token_here
```
5. Update Configuration
Ensure that the config/services.php file includes the Electricity Maps configuration:
```php
'electricity_maps' =>  [
    'token' => env('ELECTRICITY_MAPS_API_TOKEN'),
    'base_url' => env('ELECTRICITY_MAPS_BASE_URL'),
]
```
## Usage

You can use the Carbon Intensity Checker via an Artisan console command.

Run the following command to check the carbon intensity for a specific zone:

```php
php artisan carbon:intensity:check {zone}
```

{zone}: The zone code you want to check the carbon intensity for (e.g., DE for Germany, FR for France). If no zone is provided, it defaults to DE.

### Examples : 

Check carbon intensity for Germany (default zone):

```php
php artisan carbon:intensity:check
```

Check carbon intensity for France:

```php
php artisan carbon:intensity:check FR
```

### Command Output

The command will display:

- The current carbon intensity in grams of CO₂ equivalent per kWh (gCO2eq/kWh).
- The traffic light status based on the carbon intensity value.

Sample output : 

##### Current Carbon Intensity: 320 gCO2eq/kWh
##### Traffic Light: YELLOW

## Testing

The application includes a comprehensive test suite covering unit and feature tests

To run the tests, execute:

```php
php artisan test
```

### Test Coverage

- Unit Tests: Verify the functionality of individual components like services and enums.
- Feature Tests: Test the console command and its interaction with the application.

## Application Structure

- Console Command: CheckCarbonIntensityCommand handles user input and displays output.
- Service Layer: CarbonIntensityService processes data and applies business logic.
- API Client: CarbonIntensityApiService interacts with the Electricity Maps API.
- Data Transfer Object (DTO): CarbonIntensity encapsulates the carbon intensity data.
- Enums: TrafficLight defines traffic light statuses and contains logic for determining the status based on carbon intensity.

## License

[MIT](https://choosealicense.com/licenses/mit/)
