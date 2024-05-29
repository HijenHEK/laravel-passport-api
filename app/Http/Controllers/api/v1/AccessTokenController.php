<?php
namespace App\Http\Controllers\api\v1;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ServerRequestInterface;

class AccessTokenController extends \Laravel\Passport\Http\Controllers\AccessTokenController 
{



        /***
         * overriding AccessToken contorller 
         * https://gist.github.com/messi89/489473c053e3ea8d9e034b0032effb1d
         */
    public function __invoke(ServerRequestInterface $request)
    {
        try {
            //get username (default is :email)
            $email = $request->getParsedBody()['username'];

            //get user
            //change to 'email' if you want
            $user = User::where('email', '=', $email)->first();

            //generate token
            $tokenResponse = parent::issueToken($request);

            //convert response to json string
            $content = $tokenResponse->getContent();

            //convert json to array
            $data = json_decode($content, true);

            if(isset($data["error"]))
                throw new OAuthServerException('The user credentials were incorrect.', 6, 'invalid_credentials', 401);

            //add access token to user
            $user = collect($user);
            $user->put('access_token', $data['access_token']);
            $user->put('hello', 'yes');
            
            return response()->json(array($user));
        }
        catch (ModelNotFoundException $e) { // email notfound
            //return error message
            return response(["message" => "User not found"], 500);
        }
        catch (OAuthServerException $e) { //password not correct..token not granted
            //return error message
            return response(["message" => "The user credentials were incorrect.', 6, 'invalid_credentials"], 500);
        }
        catch (Exception $e) {
            info($e->getMessage());
            ////return error message
            return response(["message" => "Internal server error"], 500);
        }
    }
}