<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateAddressRequest;
use App\Models\Address;
use App\Services\API\AddressService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;

class AddressController extends Controller
{
    use ApiResponse;
    private AddressService $addressService;

    /**
     * Constructor for the AddressController. Initializes the AddressService.
     * 
     * This method creates a new instance of the AddressService, which handles
     * address-related operations. It is invoked when the controller is instantiated.
     */
    public function __construct()
    {
        $this->addressService = new AddressService;
    }


    /**
     * Retrieves all addresses for the authenticated user.
     * 
     * This method fetches addresses from the AddressService and returns a JSON response
     * containing the addresses under the authenticated user.
     *
     * @return JsonResponse A JSON response containing the list of addresses under the authenticated user
     * @throws Exception If there is an error retrieving the addresses
     */
    public function index(): JsonResponse
    {
        try {
            $addresses = $this->addressService->getAddresses();
            return $this->success(200, 'addresses under the auth user', ['addresses' => $addresses]);
        } catch (Exception $e) {
            Log::error('AddressController::index:' . $e->getMessage());
            return $this->error(500, 'fail to fetch addressed', $e->getMessage());
        }
    }


    /**
     * Stores a new address for the authenticated user.
     * 
     * This method validates the incoming request using CreateAddressRequest and passes
     * the validated data to the AddressService for storing the new address.
     *
     * @param CreateAddressRequest $createAddressRequest The validated address data to be stored
     * @return JsonResponse A JSON response indicating the success or failure of the address creation
     * @throws Exception If there is an error storing the address
     */
    public function store(CreateAddressRequest $createAddressRequest): JsonResponse
    {
        try {
            $validatedData = $createAddressRequest->validated();
            $address = $this->addressService->storeAddress($validatedData);
            return $this->success(200, 'address created successfully', ['address' => $address]);
        } catch (Exception $e) {
            Log::error('AddressController::store:' . $e->getMessage());
            return $this->error(500, 'fail to store address', $e->getMessage());
        }
    }


    /**
     * Deletes an address for the authenticated user.
     * 
     * This method calls the AddressService to delete the specified address. It checks for 
     * proper authorization and ensures that the address is deleted only if the user has the 
     * right permissions. If an exception occurs, a relevant error message is returned.
     *
     * @param mixed $address The address to delete, either an Address instance or an address ID.
     * @return JsonResponse A JSON response indicating the success or failure of the address deletion
     * @throws UnauthorizedException If the user is not authorized to delete the address
     * @throws Exception If there is an error during the address deletion process
     */
    public function destroy(Address $address): JsonResponse
    {
        try {
            $this->addressService->deleteAddress($address);
            return $this->success(200, 'address deleted successfully', []);
        }
        catch (UnauthorizedException $e) {
            Log::error('AddressController::destroy:' . $e->getMessage());
            return $this->error(500, 'unauthorized access', $e->getMessage());
        } catch (Exception $e) {
            Log::error('AddressController::destroy:' . $e->getMessage());
            return $this->error(500, 'fail to delete address', $e->getMessage());
        }
    }



    /**
     * Handles the activation of an address by calling the address service
     * to activate the specified address.
     * 
     * This method processes the address activation and returns a success or error response
     * based on whether the activation succeeds or fails. It also logs errors if an issue occurs.
     * 
     * @param int $address The ID of the address to be activated.
     * 
     * @return \Illuminate\Http\JsonResponse The response containing the result of the address activation,
     *         including a success message and the activated address data or an error message.
     * 
     * @throws UnauthorizedException If the user attempts to activate an address they don't own.
     * @throws Exception If any other error occurs during the address activation process.
     */
    public function activate($address)
    {
        try {
            $address = $this->addressService->activateAddress($address);
            return $this->success(200, 'address activated successfully', ['address' => $address]);
        } catch (UnauthorizedException $e) {
            Log::error('AddressController::activate:' . $e->getMessage());
            return $this->error(500, 'unauthorized access', $e->getMessage());
        } catch (Exception $e) {
            Log::error('AddressController::activate:' . $e->getMessage());
            return $this->error(500, 'fail to activate address', $e->getMessage());
        }
    }

}
