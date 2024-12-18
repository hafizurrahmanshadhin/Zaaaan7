<?php

namespace App\Services\API;

use App\Models\Address;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\UnauthorizedException;

class AddressService
{
    private $user;

    /**
     * Constructor for the class. Initializes the authenticated user.
     * 
     * This method retrieves the authenticated user using Laravel's Auth facade
     * and assigns it to the $user property for further use in class methods.
     */
    public function __construct()
    {
        $this->user = Auth::user();
    }


    /**
     * Retrieves all addresses associated with the authenticated user.
     * 
     * @return \Illuminate\Database\Eloquent\Collection|Address[] A collection of Address models
     * @throws Exception If there is an error fetching the addresses
     */
    public function getAddresses(): mixed
    {
        try {
            return $this->user->addresses;
        } catch (Exception $e) {
            throw $e;
        }
    }


    /**
     * Stores a new address for the authenticated user.
     * 
     * This method creates a new address record based on the provided input credentials
     * and associates it with the authenticated user.
     *
     * @param array $credentials The address details to store, including latitude, longitude, name, 
     *                           country, state, city, and zip.
     * @return Address The newly created Address model instance
     * @throws Exception If there is an error storing the address
     */
    public function storeAddress(array $credentials): mixed
    {
        try {
            $address = $this->user->addresses()->create([
                'latitude' => $credentials['latitude'],
                'longitude' => $credentials['longitude'],
                'name' => $credentials['name'],
                'country' => $credentials['country'],
                'state' => $credentials['state'],
                'city' => $credentials['city'],
                'zip' => $credentials['zip'],
            ]);

            return $address;
        } catch (Exception $e) {
            throw $e;
        }
    }



    /**
     * Deletes an address associated with the authenticated user.
     * 
     * This method deletes the specified address if it belongs to the authenticated user
     * or if the user has an admin role. If the user does not have permission, an exception
     * is thrown.
     *
     * @param mixed $address The address to delete, either an Address instance or an address ID.
     * @return bool True if the address was deleted successfully
     * @throws UnauthorizedException If the user is not authorized to delete the address
     * @throws Exception If there is an error during the deletion process
     */
    public function deleteAddress($address): bool
    {
        try {
            if ($address->user_id == $this->user->id || $this->user->role == 'admin') {
                $address = Address::findOrFail($address);
                $address->delete();
                return true;
            }
            throw new UnauthorizedException('Unauthorized address deletion', 403);
        } catch (Exception $e) {
            throw $e;
        }
    }



    /**
     * Activates the given address by deactivating the current active address
     * for the user and setting the specified address as active.
     * 
     * This method performs the following actions:
     * - Verifies that the address belongs to the authenticated user.
     * - Deactivates any other active addresses for the user.
     * - Sets the provided address as active and saves the changes to the database.
     * 
     * @param int $addressId The ID of the address to be activated.
     * 
     * @return Address The activated address object.
     * 
     * @throws UnauthorizedException If the address does not belong to the authenticated user.
     * @throws Exception If any other error occurs during the activation process.
     */
    public function activateAddress($address)
    {
        try {
            DB::beginTransaction();
            $address = Address::findOrFail($address);
            if ($address->user_id !== $this->user->id) {
                throw new UnauthorizedException('Unauthorized address deletion', 403);
            }

            Address::where('user_id', $this->user->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);

            $address->is_active = true;
            $address->save();
            DB::commit();
            return $address;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
