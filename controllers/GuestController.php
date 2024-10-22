<?php
class Guest
{
    public $guestID;
    public $weddingID;
    public $name;
    public $email;
    public $phone;
    public $gender;
    public $age;
    public $city;
    public $relation;
    public $RSVP;
    public $arrivalTime;
    public $travelMode;
    public $transportName;
    public $pickup;
    public $status;
    public $createdAt;
    public $createdBy;
    public $additionalGuests;
    public $guestMessage;

    public $languages;
    public $relations;
    public $userList = ['dummy.com'];

    public $error;
    public $errorMsgs;


    // check for weddingID
    public function check($weddingID, $lang)
    {
        DB::connect();
        $result = DB::count('weddings', "weddingID = '$weddingID' AND lang = '$lang'");
        DB::close();
        return $result;
    }

// Create operation
    public function create(array $data)
    {
        // Sanitize and assign values
        DB::connect();
      
        $this->weddingID = trim(DB::sanitize($data['weddingID']));
        $this->lang = trim(DB::sanitize($data['lang'] ?? 'en'));

        $this->name = trim(DB::sanitize($data['name']));
        $this->email = trim(DB::sanitize($data['email']));
        $this->phone = trim(DB::sanitize($data['phone']));

        $this->guestID = md5(md5($this->lang.$this->phone.$this->name).md5(time().uniqid()));

        $this->gender = trim(DB::sanitize($data['gender']));
        $this->status = trim(DB::sanitize($data['status']));
        $this->createdAt = trim(DB::sanitize($data['createdAt']));
        $this->createdBy = trim(DB::sanitize($data['createdBy']));
        $this->additionalGuests = trim(DB::sanitize($data['additionalGuests']));
        $this->guestMessage = trim(DB::sanitize($data['guestMessage']));



        $this->languages = enumToArray(DB::select('information_schema.COLUMNS', 'COLUMN_TYPE', "TABLE_NAME = 'weddings'
        AND COLUMN_NAME = 'lang'")->fetch()[0]);

        $this->relations = enumToArray(DB::select('information_schema.COLUMNS', 'COLUMN_TYPE', "TABLE_NAME = 'guests'
        AND COLUMN_NAME = 'relation'")->fetch()[0]);


        $userData = DB::select('users', 'userID', "status <> 'deleted'")->fetchAll();

        foreach ($userData as $user) {
            $this->userList[] = $user['userID'];
        }

        DB::close();


        // Validation Rules

        $fields = [
            'weddingID' => [
                'value' => $this->weddingID,
                'rules' => [
                    [
                        'type' => 'required',
                        'message' => "Wedding ID can't be empty",
                    ],
                    [
                        'type' => 'eventID',
                        'message' => "Invalid Wedding ID",
                    ],
                    [
                        'type' => 'custom',
                        'message' => 'Wedding ID not exists',
                        'validate' => function () {
                            return ($this->check($this->weddingID, $this->lang));
                        },
                    ]
                ],
            ],
            'lang' => [
                'value' => $this->lang,
                'rules' => [
                    [
                        'type' => 'custom',
                        'message' => 'Language Not Supported',
                        'validate' => function () {
                            return in_array($this->lang, $this->languages);
                        },
                    ]
                ],
            ],
            'name' => [
                'value' => $this->name,
                'rules' => [
                    [
                        'type' => 'required',
                        'message' => "Name can't be empty",
                    ],
                    [
                        'type' => 'minLength',
                        'message' => 'Invalid Name',
                        'minLength' => 3
                    ]
                ],
            ],
            'phone' => [
                'value' => $this->phone,
                'rules' => [
                    [
                        'type' => 'phone',
                        'message' => 'Invalid Phone Number'
                    ],
                ],
            ],
            'email' => [
                'value' => $this->email,
                'rules' => [
                    [
                        'type' => 'email',
                        'message' => 'Invalid Email'
                    ],
                ],
            ],
 
        ];

        // Call the Validator::validate function
        $validate = Validator::validate($fields);

        if ($validate['error']) {
            return ['error' => $validate['error'], 'errorMsgs' => $validate['errorMsgs']];
        } else {
            // Prepare data array
            $data = [
                'weddingID' => $this->weddingID,
                'guestID' => $this->guestID,
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'additionalGuests' => $this->additionalGuests,
                'guestMessage' => $this->guestMessage,
                'gender' => $this->gender,
                'createdBy' => $this->createdBy,
                'createdAt' => date('Y-m-d H:i:s'),
                'status' => 'pending',
            ];


            // Insert data into the 'guests' table
            DB::connect();
            $createGuest = DB::insert('guests', $data); DB::close();

            // Handle success/failure
            if ($createGuest) {
                $this->error = false;
                $this->errorMsgs['createGuest'] = '';
            } else {
                $this->error = true;
                $this->errorMsgs['createGuest'] = 'Guest Creation Failed';
            }

            if ($this->error) {
                return ['error' => $this->error, 'errorMsgs' => $this->errorMsgs];
            } else {
                return ['error' => $this->error, 'errorMsgs' => $this->errorMsgs, 'message' => 'Guest Creation successful'];
            }
        }
    }
    // create function ends

    // Edit operation
    public function updateGuest(array $data)
    {
        // Sanitize and assign values
        DB::connect();
        $this->guestID = trim(DB::sanitize($data['guestID']));
        $this->weddingID = trim(DB::sanitize($data['weddingID']));
        $this->lang = trim(DB::sanitize($data['lang'] ?? 'en'));

        $this->name = trim(DB::sanitize($data['name']));
        $this->email = trim(DB::sanitize($data['email']));
        $this->phone = trim(DB::sanitize($data['phone']));
        $this->gender = trim(DB::sanitize($data['gender']));
        $this->age = trim(DB::sanitize($data['age']));
        $this->city = trim(DB::sanitize($data['city']));
        $this->relation = trim(DB::sanitize($data['relation']));
        $this->RSVP = trim(DB::sanitize($data['RSVP']));
        $this->arrivalTime = trim(DB::sanitize($data['arrivalTime']));
        $this->travelMode = trim(DB::sanitize($data['travelMode']));
        $this->transportName = trim(DB::sanitize($data['transportName']));
        $this->pickup = trim(DB::sanitize($data['pickup']));
        $this->status = trim(DB::sanitize($data['status']));
        $this->createdAt = trim(DB::sanitize($data['createdAt']));
        $this->createdBy = trim(DB::sanitize($data['createdBy']));
        $this->additionalGuests = trim(DB::sanitize($data['additionalGuests']));
        $this->guestMessage = trim(DB::sanitize($data['guestMessage']));



        $this->languages = enumToArray(DB::select('information_schema.COLUMNS', 'COLUMN_TYPE', "TABLE_NAME = 'weddings'
        AND COLUMN_NAME = 'lang'")->fetch()[0]);

        $this->relations = enumToArray(DB::select('information_schema.COLUMNS', 'COLUMN_TYPE', "TABLE_NAME = 'guests'
        AND COLUMN_NAME = 'relation'")->fetch()[0]);


        $userData = DB::select('users', 'userID', "status <> 'deleted'")->fetchAll();

        foreach ($userData as $user) {
            $this->userList[] = $user['userID'];
        }

        DB::close();


        // Validation Rules

        $fields = [
            'weddingID' => [
                'value' => $this->weddingID,
                'rules' => [
                    [
                        'type' => 'required',
                        'message' => "Wedding ID can't be empty",
                    ],
                    [
                        'type' => 'eventID',
                        'message' => "Invalid Wedding ID",
                    ],
                    [
                        'type' => 'custom',
                        'message' => 'Wedding ID not exists',
                        'validate' => function () {
                            return ($this->check($this->weddingID, $this->lang));
                        },
                    ]
                ],
            ],
            'lang' => [
                'value' => $this->lang,
                'rules' => [
                    [
                        'type' => 'custom',
                        'message' => 'Language Not Supported',
                        'validate' => function () {
                            return in_array($this->lang, $this->languages);
                        },
                    ]
                ],
            ],
            'relation' => [
                'value' => $this->relation,
                'rules' => [
                    [
                        'type' => 'required',
                        'message' => "Relation can't be empty",
                    ],
                    [
                        'type' => 'custom',
                        'message' => 'Invalid relation field',
                        'validate' => function () {
                            return in_array($this->relation, $this->relations);
                        },
                    ]
                ],
            ],
            'name' => [
                'value' => $this->name,
                'rules' => [
                    [
                        'type' => 'required',
                        'message' => "Name can't be empty",
                    ],
                    [
                        'type' => 'minLength',
                        'message' => 'Invalid Name',
                        'minLength' => 3
                    ]
                ],
            ],
            'phone' => [
                'value' => $this->phone,
                'rules' => [
                    [
                        'type' => 'phone',
                        'message' => 'Invalid Phone Number'
                    ],
                ],
            ],
            'email' => [
                'value' => $this->email,
                'rules' => [
                    [
                        'type' => 'email',
                        'message' => 'Invalid Email'
                    ],
                ],
            ],
 
        ];

        // Call the Validator::validate function
        $validate = Validator::validate($fields);

        if ($validate['error']) {
            return ['error' => $validate['error'], 'errorMsgs' => $validate['errorMsgs']];
        } else {
            // Prepare data array
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'gender' => $this->gender,
                'lang' => $this->lang,
                'age' => $this->age,
                'city' => $this->city,
                'relation' => $this->relation,
                'RSVP' => $this->RSVP,
                'arrivalTime' => $this->arrivalTime,
                'travelMode' => $this->travelMode,
                'transportName' => $this->transportName,
                'pickup' => $this->pickup,
                'createdBy' => $this->createdBy,
                'createdAt' => date('Y-m-d H:i:s'),
                'status' => 'pending',
                'additionalGuests' => $this->additionalGuests,
                'guestMessage' => $this->guestMessage
            ];


            // Insert data into the 'guests' table
            DB::connect();
            $createGuest = DB::update('guests', $data,"guestID = '$this->guestID'"); DB::close();

            // Handle success/failure
            if ($createGuest) {
                $this->error = false;
                $this->errorMsgs['createGuest'] = '';
            } else {
                $this->error = true;
                $this->errorMsgs['createGuest'] = 'Guest Updation Failed';
            }

            if ($this->error) {
                return ['error' => $this->error, 'errorMsgs' => $this->errorMsgs];
            } else {
                return ['error' => $this->error, 'errorMsgs' => $this->errorMsgs, 'message' => 'Guest Updation successful'];
            }
        }
    }
    // Update function ends


    public function getGuest($weddingID,$guestID)
    {
        DB::connect();
        $weddingID = DB::sanitize($weddingID);
        $guestID=DB::sanitize($guestID);

        $getGuest = DB::select('guests', '*', "weddingID = '$weddingID' and guestID='$guestID' ")->fetch();

        DB::close();

        if ($getGuest)
            return $getGuest;
        else
            return ['error' => true, "errorMsgs" => ['guest' => "Guest Not Found"]];
    }
    // getGuest() ends


    public function delete($weddingID, $guestID)
    {

        $check = $this->getGuest($weddingID, $guestID);

        if ($check['error']) {
            return $check;
        }

        // Delete the wedding
        DB::connect();
        $deleteGuest = DB::delete('guests', "weddingID = '$weddingID' and guestID='$guestID' ");
        DB::close();

        if (!$deleteGuest) {
            return [
                'error' => true,
                'errorMsg' => 'Failed to delete Guest'
            ];
        } else {
            return [
                'error' => false,
                'errorMsg' => '',
                'message' => "$guestID successfully deleted"
            ];
        }
    }
    //  delete() ends


}


















