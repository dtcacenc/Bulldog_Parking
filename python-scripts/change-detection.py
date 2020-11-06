#!/usr/bin/env python3
import cv2 as cv

# Extract frames from video
'''
cap = cv.VideoCapture("p_lot.mp4")
i = 0
while cap.isOpened():
    ret, frame = cap.read()
    if not ret:
        break
    cv.imwrite("frame_" + str(i) + ".jpg", frame)
    i += 1

cap.release()
cv.destroyAllWindows()
'''


# constructor for a lot object
class space:
    def __init__(self, number, state, y, x, h, w):
        self.number = number    # first digit is row, second digit is # of car
        self.state = state      # can be 1 or -1 (occupied or empty)
        self.y = y              # y, x, h, w are coordinates for cropping out individual spaces
        self.x = x
        self.h = h
        self.w = w


# initialize list "parking_lot". State is based on frame_0.jpg
parking_lot = []
parking_lot.append(space('00', 1, 128, 133, 33, 29))
parking_lot.append(space('01', 1, 137, 41, 233, 130))
parking_lot.append(space('02', 1, 240, 32, 335, 137))
parking_lot.append(space('03', 1, 344, 26, 437, 127))
parking_lot.append(space('04', 1, 447, 28, 531, 125))
parking_lot.append(space('05', 1, 544, 21, 633, 128))
parking_lot.append(space('06', 1, 647, 24, 738, 123))
parking_lot.append(space('07', 1, 747, 17, 835, 106))
parking_lot.append(space('08', 1, 859, 12, 927, 111))
parking_lot.append(space('09', 1, 953, 17, 1032, 111))

parking_lot.append(space('10', 1, 32, 170, 124, 200))
parking_lot.append(space('11', 1, 145, 182, 213, 198))
parking_lot.append(space('12', -1, 332, 255, 247, 183))
parking_lot.append(space('13', 1, 360, 176, 443, 238))
parking_lot.append(space('14', 1, 462, 172, 548, 242))
parking_lot.append(space('15', 1, 573, 168, 662, 235))
parking_lot.append(space('16', 1, 771, 216, 685, 172))
parking_lot.append(space('17', 1, 799, 170, 871, 190))
parking_lot.append(space('18', 1, 901, 172, 979, 220))
parking_lot.append(space('19', 1, 1008, 181, 1088, 217))

'''
parking_lot.append(space('20', 1, ))
parking_lot.append(space('21', 1, ))
parking_lot.append(space('22', 1, ))
parking_lot.append(space('23', 1, ))
parking_lot.append(space('24', 1, ))
parking_lot.append(space('25', 1, ))
parking_lot.append(space('26', 1, ))
parking_lot.append(space('27', 1, ))
parking_lot.append(space('28', 1, ))
parking_lot.append(space('29', 1, ))

parking_lot.append(space('30', 1, ))
parking_lot.append(space('31', 1, ))
parking_lot.append(space('32', 1, ))
parking_lot.append(space('33', 1, ))
parking_lot.append(space('34', 1, ))
parking_lot.append(space('35', 1, ))
parking_lot.append(space('36', 1, ))
parking_lot.append(space('37', 1, ))
parking_lot.append(space('38', 1, ))
parking_lot.append(space('39', 1, ))
'''


# -------- Constants & variables ---------
# THRESHOLD = value between 0.0-255.0. When there's a change in the mean value
# (of all the pixels in the cropped image) that exceeds this threshold, it is
# safe to assume that a car has occupied/left the space
THRESHOLD = 42.0

# parking_lot_total counts how many cars are on the lot
parking_lot_total = 0

# calculate total # of cars
for space in parking_lot:
    if space.state > 0:
        parking_lot_total += space.state

print("START: Total # cars in lot: " + str(parking_lot_total))

# analyze frames at intervals-offsets: 8-4, 19-0, 32-0 work pretty well
# jump at intervals, but also check every 60 and 120 frames back with frame 1 to confirm
interval = [8]
offset = [4]
for i in range(0 + offset[0], 431 - interval[0], interval[0]):
    img_path = cv.imread(r"frame_" + str(i) + ".jpg")
    img1 = cv.cvtColor(img_path, cv.COLOR_BGR2GRAY)
    img_path = cv.imread(r"frame_" + str(i + interval[0]) + ".jpg")
    img2 = cv.cvtColor(img_path, cv.COLOR_BGR2GRAY)

    # set variables for cropping image x:w, y:h
    for space in parking_lot:
        # crop image
        crop1 = img1[space.x: space.w, space.y:space.h]
        crop2 = img2[space.x: space.w, space.y:space.h]
        mask = cv.subtract(crop1, crop2)
        mean = cv.mean(mask)[0]
        # if the difference between the images is  above the threshold,
        # then we toggle the parking space state
        if mean > THRESHOLD:
            space.state = space.state * -1  # switch state to -1
            parking_lot_total += space.state  # add to total. If negative, it subtracts
            # print where detected change
            print("\nframe_" + str(i) + "/" + str(i + interval[0]))
            print("space[" + str(space.number) + "] : " + str(mean))
            print("\t" + str(space.state))


print("FINISH: Total # cars in lot: " + str(parking_lot_total))
print("----------------- should be (19)")

# Update the test.txt file with numbers from processing the video
file = open("test.txt", "w")
string = ""
for x in range(7):
    if parking_lot[x].state == 1:
        string = string + str(1)
    if parking_lot[x].state == -1:
        string = string + str(0)
file.write(string)
file.close()


# TODO: need to devise a way to validate the count of total cars.
#       some cars take 4 frames to leave, other cars
#       take like 15 frames to back into a parking lot...
#
#       one way to do this is instead of comparing each spot to an earlier version of itself is
#       to compare each lot to the general color of an empty lot! lol It could work very well!

# TODO: add rest of the coordinates in list parking_lot[]
