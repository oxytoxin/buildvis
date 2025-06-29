export interface Room {
    position: [number, number, number];
    dimensions: [number, number, number];
    outerWalls: {
        front: boolean;
        back: boolean;
        left: boolean;
        right: boolean;
    };
    windows: {
        front?: [number, number, number]; // [x, y, z] position
        back?: [number, number, number];
        left?: [number, number, number];
        right?: [number, number, number];
    };
    story: number; // Add story number to track which floor the room is on
}

export interface HouseDimensions {
    length: number;
    width: number;
    height: number;
}

export interface Story {
    numRooms: number;
    height: number;
}

// Helper function to calculate window positions for a room
const calculateWindowPositions = (
    roomDimensions: [number, number, number],
    outerWalls: { front: boolean; back: boolean; left: boolean; right: boolean },
    wallThickness: number = 0.2
): { front?: [number, number, number]; back?: [number, number, number]; left?: [number, number, number]; right?: [number, number, number] } => {
    const [width, height, length] = roomDimensions;

    // Window height position (0.5m from bottom)
    const windowY = -(height / 2) + 0.5 + 1; // 0.5m window height, positioned 0.5m from bottom

    const windows: { front?: [number, number, number]; back?: [number, number, number]; left?: [number, number, number]; right?: [number, number, number] } = {};

    if (outerWalls.front) {
        windows.front = [0, windowY, -(length / 2) + (wallThickness / 2)];
    }
    if (outerWalls.back) {
        windows.back = [0, windowY, (length / 2) - (wallThickness / 2)];
    }
    if (outerWalls.left) {
        windows.left = [-(width / 2) + (wallThickness / 2), windowY, 0];
    }
    if (outerWalls.right) {
        windows.right = [(width / 2) - (wallThickness / 2), windowY, 0];
    }

    return windows;
};

// Helper function to determine outer walls for 3-room layouts
const calculateOuterWallsFor3Rooms = (
    roomIndex: number,
    isHorizontalSplit: boolean
): { front: boolean; back: boolean; left: boolean; right: boolean } => {
    if (isHorizontalSplit) {
        // Two rooms on top, one on bottom
        switch (roomIndex) {
            case 0: // Top-left room
                return { front: true, back: false, left: true, right: false };
            case 1: // Top-right room
                return { front: true, back: false, left: false, right: true };
            case 2: // Bottom room
                return { front: false, back: true, left: true, right: true };
            default:
                return { front: false, back: false, left: false, right: false };
        }
    } else {
        // Two rooms on left, one on right
        switch (roomIndex) {
            case 0: // Left room
                return { front: true, back: true, left: true, right: false };
            case 1: // Top-right room
                return { front: true, back: false, left: false, right: true };
            case 2: // Bottom-right room
                return { front: false, back: true, left: false, right: true };
            default:
                return { front: false, back: false, left: false, right: false };
        }
    }
};

export function calculateRoomLayout(stories: Story[], dimensions: HouseDimensions): Room[] {
    const rooms: Room[] = [];
    let currentY = 0; // Track the current Y position for stacking stories

    stories.forEach((story, storyIndex) => {
        const storyRooms = calculateSingleStoryRooms(story.numRooms, {
            ...dimensions,
            height: story.height
        }, currentY, storyIndex);

        rooms.push(...storyRooms);
        currentY += story.height; // Move up for next story
    });

    return rooms;
}

// Helper function to calculate rooms for a single story
function calculateSingleStoryRooms(numRooms: number, dimensions: HouseDimensions, yOffset: number, storyIndex: number): Room[] {
    const rooms: Room[] = [];
    const roomHeight = dimensions.height;

    if (numRooms === 1) {
        const outerWalls = {
            front: true,
            back: true,
            left: true,
            right: true,
        };

        const room: Room = {
            position: [0, yOffset + roomHeight / 2, 0],
            dimensions: [dimensions.width, roomHeight, dimensions.length],
            outerWalls,
            windows: calculateWindowPositions([dimensions.width, roomHeight, dimensions.length], outerWalls),
            story: storyIndex
        };
        rooms.push(room);
    } else if (numRooms === 2) {
        const roomWidth = dimensions.width / 2;
        const roomLength = dimensions.length;

        // Check if we should split horizontally or vertically
        if (dimensions.width >= dimensions.length) {
            // Split horizontally
            const leftOuterWalls = {
                front: true,   // Front edge of house
                back: true,    // Back edge of house
                left: true,    // Left edge of house
                right: false,  // Shared with right room
            };

            const leftRoom: Room = {
                position: [-(dimensions.width / 4), yOffset + roomHeight / 2, 0],
                dimensions: [roomWidth, roomHeight, dimensions.length],
                outerWalls: leftOuterWalls,
                windows: calculateWindowPositions([roomWidth, roomHeight, dimensions.length], leftOuterWalls),
                story: storyIndex
            };
            rooms.push(leftRoom);

            const rightOuterWalls = {
                front: true,   // Front edge of house
                back: true,    // Back edge of house
                left: false,   // Shared with left room
                right: true,   // Right edge of house
            };

            const rightRoom: Room = {
                position: [dimensions.width / 4, yOffset + roomHeight / 2, 0],
                dimensions: [roomWidth, roomHeight, dimensions.length],
                outerWalls: rightOuterWalls,
                windows: calculateWindowPositions([roomWidth, roomHeight, dimensions.length], rightOuterWalls),
                story: storyIndex
            };
            rooms.push(rightRoom);
        } else {
            // Split vertically
            const topOuterWalls = {
                front: true,   // Front edge of house
                back: false,   // Shared with bottom room
                left: true,    // Left edge of house
                right: true,   // Right edge of house
            };

            const topRoom: Room = {
                position: [0, yOffset + roomHeight / 2, -(dimensions.length / 4)],
                dimensions: [dimensions.width, roomHeight, dimensions.length / 2],
                outerWalls: topOuterWalls,
                windows: calculateWindowPositions([dimensions.width, roomHeight, dimensions.length / 2], topOuterWalls),
                story: storyIndex
            };
            rooms.push(topRoom);

            const bottomOuterWalls = {
                front: false,  // Shared with top room
                back: true,    // Back edge of house
                left: true,    // Left edge of house
                right: true,   // Right edge of house
            };

            const bottomRoom: Room = {
                position: [0, yOffset + roomHeight / 2, dimensions.length / 4],
                dimensions: [dimensions.width, roomHeight, dimensions.length / 2],
                outerWalls: bottomOuterWalls,
                windows: calculateWindowPositions([dimensions.width, roomHeight, dimensions.length / 2], bottomOuterWalls),
                story: storyIndex
            };
            rooms.push(bottomRoom);
        }
    } else if (numRooms === 3) {
        const isHorizontalSplit = dimensions.width >= dimensions.length;

        if (isHorizontalSplit) {
            // Two rooms on top, one on bottom
            const topRoomWidth = dimensions.width / 2;
            const topRoomLength = dimensions.length / 2;

            const topLeftOuterWalls = calculateOuterWallsFor3Rooms(0, true);
            const topLeftRoom: Room = {
                position: [-(dimensions.width / 4), yOffset + roomHeight / 2, -(dimensions.length / 4)],
                dimensions: [topRoomWidth, roomHeight, topRoomLength],
                outerWalls: topLeftOuterWalls,
                windows: calculateWindowPositions([topRoomWidth, roomHeight, topRoomLength], topLeftOuterWalls),
                story: storyIndex
            };
            rooms.push(topLeftRoom);

            const topRightOuterWalls = calculateOuterWallsFor3Rooms(1, true);
            const topRightRoom: Room = {
                position: [dimensions.width / 4, yOffset + roomHeight / 2, -(dimensions.length / 4)],
                dimensions: [topRoomWidth, roomHeight, topRoomLength],
                outerWalls: topRightOuterWalls,
                windows: calculateWindowPositions([topRoomWidth, roomHeight, topRoomLength], topRightOuterWalls),
                story: storyIndex
            };
            rooms.push(topRightRoom);

            const bottomOuterWalls = calculateOuterWallsFor3Rooms(2, true);
            const bottomRoom: Room = {
                position: [0, yOffset + roomHeight / 2, dimensions.length / 4],
                dimensions: [dimensions.width, roomHeight, dimensions.length / 2],
                outerWalls: bottomOuterWalls,
                windows: calculateWindowPositions([dimensions.width, roomHeight, dimensions.length / 2], bottomOuterWalls),
                story: storyIndex
            };
            rooms.push(bottomRoom);
        } else {
            // Two rooms on left, one on right
            const leftRoomWidth = dimensions.width / 2;
            const rightRoomWidth = dimensions.width / 2;
            const rightRoomLength = dimensions.length / 2;

            const leftOuterWalls = calculateOuterWallsFor3Rooms(0, false);
            const leftRoom: Room = {
                position: [-(dimensions.width / 4), yOffset + roomHeight / 2, 0],
                dimensions: [leftRoomWidth, roomHeight, dimensions.length],
                outerWalls: leftOuterWalls,
                windows: calculateWindowPositions([leftRoomWidth, roomHeight, dimensions.length], leftOuterWalls),
                story: storyIndex
            };
            rooms.push(leftRoom);

            const topRightOuterWalls = calculateOuterWallsFor3Rooms(1, false);
            const topRightRoom: Room = {
                position: [dimensions.width / 4, yOffset + roomHeight / 2, -(dimensions.length / 4)],
                dimensions: [rightRoomWidth, roomHeight, rightRoomLength],
                outerWalls: topRightOuterWalls,
                windows: calculateWindowPositions([rightRoomWidth, roomHeight, rightRoomLength], topRightOuterWalls),
                story: storyIndex
            };
            rooms.push(topRightRoom);

            const bottomRightOuterWalls = calculateOuterWallsFor3Rooms(2, false);
            const bottomRightRoom: Room = {
                position: [dimensions.width / 4, yOffset + roomHeight / 2, dimensions.length / 4],
                dimensions: [rightRoomWidth, roomHeight, rightRoomLength],
                outerWalls: bottomRightOuterWalls,
                windows: calculateWindowPositions([rightRoomWidth, roomHeight, rightRoomLength], bottomRightOuterWalls),
                story: storyIndex
            };
            rooms.push(bottomRightRoom);
        }
    } else if (numRooms === 4) {
        const roomWidth = dimensions.width / 2;
        const roomLength = dimensions.length / 2;

        // Create a 2x2 grid with proper outer wall detection
        const topLeftOuterWalls = {
            front: true,   // Top edge of house
            back: false,   // Shared with bottom room
            left: true,    // Left edge of house
            right: false,  // Shared with right room
        };

        const topLeftRoom: Room = {
            position: [-(dimensions.width / 4), yOffset + roomHeight / 2, -(dimensions.length / 4)],
            dimensions: [roomWidth, roomHeight, roomLength],
            outerWalls: topLeftOuterWalls,
            windows: calculateWindowPositions([roomWidth, roomHeight, roomLength], topLeftOuterWalls),
            story: storyIndex
        };
        rooms.push(topLeftRoom);

        const topRightOuterWalls = {
            front: true,   // Top edge of house
            back: false,   // Shared with bottom room
            left: false,   // Shared with left room
            right: true,   // Right edge of house
        };

        const topRightRoom: Room = {
            position: [dimensions.width / 4, yOffset + roomHeight / 2, -(dimensions.length / 4)],
            dimensions: [roomWidth, roomHeight, roomLength],
            outerWalls: topRightOuterWalls,
            windows: calculateWindowPositions([roomWidth, roomHeight, roomLength], topRightOuterWalls),
            story: storyIndex
        };
        rooms.push(topRightRoom);

        const bottomLeftOuterWalls = {
            front: false,  // Shared with top room
            back: true,    // Bottom edge of house
            left: true,    // Left edge of house
            right: false,  // Shared with right room
        };

        const bottomLeftRoom: Room = {
            position: [-(dimensions.width / 4), yOffset + roomHeight / 2, dimensions.length / 4],
            dimensions: [roomWidth, roomHeight, roomLength],
            outerWalls: bottomLeftOuterWalls,
            windows: calculateWindowPositions([roomWidth, roomHeight, roomLength], bottomLeftOuterWalls),
            story: storyIndex
        };
        rooms.push(bottomLeftRoom);

        const bottomRightOuterWalls = {
            front: false,  // Shared with top room
            back: true,    // Bottom edge of house
            left: false,   // Shared with left room
            right: true,   // Right edge of house
        };

        const bottomRightRoom: Room = {
            position: [dimensions.width / 4, yOffset + roomHeight / 2, dimensions.length / 4],
            dimensions: [roomWidth, roomHeight, roomLength],
            outerWalls: bottomRightOuterWalls,
            windows: calculateWindowPositions([roomWidth, roomHeight, roomLength], bottomRightOuterWalls),
            story: storyIndex
        };
        rooms.push(bottomRightRoom);
    } else if (numRooms === 5) {
        const roomWidth = dimensions.width / 3;
        const roomLength = dimensions.length / 2;

        // Top row: 3 rooms
        for (let i = 0; i < 3; i++) {
            const x = -(dimensions.width / 3) + (i * dimensions.width / 3);
            const outerWalls = {
                front: true,   // Front edge of house
                back: false,   // Shared with bottom rooms
                left: i === 0, // Only leftmost room has left wall
                right: i === 2, // Only rightmost room has right wall
            };

            const room: Room = {
                position: [x, yOffset + roomHeight / 2, -(dimensions.length / 4)],
                dimensions: [roomWidth, roomHeight, roomLength],
                outerWalls,
                windows: calculateWindowPositions([roomWidth, roomHeight, roomLength], outerWalls),
                story: storyIndex
            };
            rooms.push(room);
        }

        // Bottom row: 2 rooms
        const bottomRoomWidth = dimensions.width / 2;
        const bottomRoomLength = dimensions.length / 2;

        const bottomLeftOuterWalls = {
            front: false,  // Shared with top rooms
            back: true,    // Back edge of house
            left: true,    // Left edge of house
            right: false,  // Shared with right room
        };

        const bottomLeftRoom: Room = {
            position: [-(dimensions.width / 4), yOffset + roomHeight / 2, dimensions.length / 4],
            dimensions: [bottomRoomWidth, roomHeight, bottomRoomLength],
            outerWalls: bottomLeftOuterWalls,
            windows: calculateWindowPositions([bottomRoomWidth, roomHeight, bottomRoomLength], bottomLeftOuterWalls),
            story: storyIndex
        };
        rooms.push(bottomLeftRoom);

        const bottomRightOuterWalls = {
            front: false,  // Shared with top rooms
            back: true,    // Back edge of house
            left: false,   // Shared with left room
            right: true,   // Right edge of house
        };

        const bottomRightRoom: Room = {
            position: [dimensions.width / 4, yOffset + roomHeight / 2, dimensions.length / 4],
            dimensions: [bottomRoomWidth, roomHeight, bottomRoomLength],
            outerWalls: bottomRightOuterWalls,
            windows: calculateWindowPositions([bottomRoomWidth, roomHeight, bottomRoomLength], bottomRightOuterWalls),
            story: storyIndex
        };
        rooms.push(bottomRightRoom);
    } else if (numRooms === 6) {
        const roomWidth = dimensions.width / 3;
        const roomLength = dimensions.length / 2;

        // Top row: 3 rooms
        for (let i = 0; i < 3; i++) {
            const x = -(dimensions.width / 3) + (i * dimensions.width / 3);
            const outerWalls = {
                front: true,   // Front edge of house
                back: false,   // Shared with bottom rooms
                left: i === 0, // Only leftmost room has left wall
                right: i === 2, // Only rightmost room has right wall
            };

            const room: Room = {
                position: [x, yOffset + roomHeight / 2, -(dimensions.length / 4)],
                dimensions: [roomWidth, roomHeight, roomLength],
                outerWalls,
                windows: calculateWindowPositions([roomWidth, roomHeight, roomLength], outerWalls),
                story: storyIndex
            };
            rooms.push(room);
        }

        // Bottom row: 3 rooms
        for (let i = 0; i < 3; i++) {
            const x = -(dimensions.width / 3) + (i * dimensions.width / 3);
            const outerWalls = {
                front: false,  // Shared with top rooms
                back: true,    // Back edge of house
                left: i === 0, // Only leftmost room has left wall
                right: i === 2, // Only rightmost room has right wall
            };

            const room: Room = {
                position: [x, yOffset + roomHeight / 2, dimensions.length / 4],
                dimensions: [roomWidth, roomHeight, roomLength],
                outerWalls,
                windows: calculateWindowPositions([roomWidth, roomHeight, roomLength], outerWalls),
                story: storyIndex
            };
            rooms.push(room);
        }
    } else if (numRooms === 7) {
        const roomWidth = dimensions.width / 3;
        const roomLength = dimensions.length / 3;

        // Top row: 3 rooms
        for (let i = 0; i < 3; i++) {
            const x = -(dimensions.width / 3) + (i * dimensions.width / 3);
            const outerWalls = {
                front: true,   // Front edge of house
                back: false,   // Shared with middle rooms
                left: i === 0, // Only leftmost room has left wall
                right: i === 2, // Only rightmost room has right wall
            };

            const room: Room = {
                position: [x, yOffset + roomHeight / 2, -(dimensions.length / 3)],
                dimensions: [roomWidth, roomHeight, roomLength],
                outerWalls,
                windows: calculateWindowPositions([roomWidth, roomHeight, roomLength], outerWalls),
                story: storyIndex
            };
            rooms.push(room);
        }

        // Middle row: 2 rooms
        const middleRoomWidth = dimensions.width / 2;
        const middleRoomLength = dimensions.length / 3;

        const middleLeftOuterWalls = {
            front: false,  // Shared with top rooms
            back: false,   // Shared with bottom rooms
            left: true,    // Left edge of house
            right: false,  // Shared with right room
        };

        const middleLeftRoom: Room = {
            position: [-(dimensions.width / 4), yOffset + roomHeight / 2, 0],
            dimensions: [middleRoomWidth, roomHeight, middleRoomLength],
            outerWalls: middleLeftOuterWalls,
            windows: calculateWindowPositions([middleRoomWidth, roomHeight, middleRoomLength], middleLeftOuterWalls),
            story: storyIndex
        };
        rooms.push(middleLeftRoom);

        const middleRightOuterWalls = {
            front: false,  // Shared with top rooms
            back: false,   // Shared with bottom rooms
            left: false,   // Shared with left room
            right: true,   // Right edge of house
        };

        const middleRightRoom: Room = {
            position: [dimensions.width / 4, yOffset + roomHeight / 2, 0],
            dimensions: [middleRoomWidth, roomHeight, middleRoomLength],
            outerWalls: middleRightOuterWalls,
            windows: calculateWindowPositions([middleRoomWidth, roomHeight, middleRoomLength], middleRightOuterWalls),
            story: storyIndex
        };
        rooms.push(middleRightRoom);

        // Bottom row: 2 rooms
        const bottomRoomWidth = dimensions.width / 2;
        const bottomRoomLength = dimensions.length / 3;

        const bottomLeftOuterWalls = {
            front: false,  // Shared with middle rooms
            back: true,    // Back edge of house
            left: true,    // Left edge of house
            right: false,  // Shared with right room
        };

        const bottomLeftRoom: Room = {
            position: [-(dimensions.width / 4), yOffset + roomHeight / 2, dimensions.length / 3],
            dimensions: [bottomRoomWidth, roomHeight, bottomRoomLength],
            outerWalls: bottomLeftOuterWalls,
            windows: calculateWindowPositions([bottomRoomWidth, roomHeight, bottomRoomLength], bottomLeftOuterWalls),
            story: storyIndex
        };
        rooms.push(bottomLeftRoom);

        const bottomRightOuterWalls = {
            front: false,  // Shared with middle rooms
            back: true,    // Back edge of house
            left: false,   // Shared with left room
            right: true,   // Right edge of house
        };

        const bottomRightRoom: Room = {
            position: [dimensions.width / 4, yOffset + roomHeight / 2, dimensions.length / 3],
            dimensions: [bottomRoomWidth, roomHeight, bottomRoomLength],
            outerWalls: bottomRightOuterWalls,
            windows: calculateWindowPositions([bottomRoomWidth, roomHeight, bottomRoomLength], bottomRightOuterWalls),
            story: storyIndex
        };
        rooms.push(bottomRightRoom);
    } else if (numRooms === 8) {
        const roomWidth = dimensions.width / 3;
        const roomLength = dimensions.length / 3;

        // Top row: 3 rooms
        for (let i = 0; i < 3; i++) {
            const x = -(dimensions.width / 3) + (i * dimensions.width / 3);
            const outerWalls = {
                front: true,   // Front edge of house
                back: false,   // Shared with middle rooms
                left: i === 0, // Only leftmost room has left wall
                right: i === 2, // Only rightmost room has right wall
            };

            const room: Room = {
                position: [x, yOffset + roomHeight / 2, -(dimensions.length / 3)],
                dimensions: [roomWidth, roomHeight, roomLength],
                outerWalls,
                windows: calculateWindowPositions([roomWidth, roomHeight, roomLength], outerWalls),
                story: storyIndex
            };
            rooms.push(room);
        }

        // Middle row: 2 rooms
        const middleRoomWidth = dimensions.width / 2;
        const middleRoomLength = dimensions.length / 3;

        const middleLeftOuterWalls = {
            front: false,  // Shared with top rooms
            back: false,   // Shared with bottom rooms
            left: true,    // Left edge of house
            right: false,  // Shared with right room
        };

        const middleLeftRoom: Room = {
            position: [-(dimensions.width / 4), yOffset + roomHeight / 2, 0],
            dimensions: [middleRoomWidth, roomHeight, middleRoomLength],
            outerWalls: middleLeftOuterWalls,
            windows: calculateWindowPositions([middleRoomWidth, roomHeight, middleRoomLength], middleLeftOuterWalls),
            story: storyIndex
        };
        rooms.push(middleLeftRoom);

        const middleRightOuterWalls = {
            front: false,  // Shared with top rooms
            back: false,   // Shared with bottom rooms
            left: false,   // Shared with left room
            right: true,   // Right edge of house
        };

        const middleRightRoom: Room = {
            position: [dimensions.width / 4, yOffset + roomHeight / 2, 0],
            dimensions: [middleRoomWidth, roomHeight, middleRoomLength],
            outerWalls: middleRightOuterWalls,
            windows: calculateWindowPositions([middleRoomWidth, roomHeight, middleRoomLength], middleRightOuterWalls),
            story: storyIndex
        };
        rooms.push(middleRightRoom);

        // Bottom row: 3 rooms
        for (let i = 0; i < 3; i++) {
            const x = -(dimensions.width / 3) + (i * dimensions.width / 3);
            const outerWalls = {
                front: false,  // Shared with middle rooms
                back: true,    // Back edge of house
                left: i === 0, // Only leftmost room has left wall
                right: i === 2, // Only rightmost room has right wall
            };

            const room: Room = {
                position: [x, yOffset + roomHeight / 2, dimensions.length / 3],
                dimensions: [roomWidth, roomHeight, roomLength],
                outerWalls,
                windows: calculateWindowPositions([roomWidth, roomHeight, roomLength], outerWalls),
                story: storyIndex
            };
            rooms.push(room);
        }
    } else if (numRooms === 9) {
        const roomWidth = dimensions.width / 3;
        const roomLength = dimensions.length / 3;

        // Create a 3x3 grid
        for (let row = 0; row < 3; row++) {
            for (let col = 0; col < 3; col++) {
                const x = -(dimensions.width / 3) + (col * dimensions.width / 3);
                const z = -(dimensions.length / 3) + (row * dimensions.length / 3);

                const outerWalls = {
                    front: row === 0,  // Only top row has front wall
                    back: row === 2,   // Only bottom row has back wall
                    left: col === 0,   // Only left column has left wall
                    right: col === 2,  // Only right column has right wall
                };

                const room: Room = {
                    position: [x, yOffset + roomHeight / 2, z],
                    dimensions: [roomWidth, roomHeight, roomLength],
                    outerWalls,
                    windows: calculateWindowPositions([roomWidth, roomHeight, roomLength], outerWalls),
                    story: storyIndex
                };
                rooms.push(room);
            }
        }
    } else {
        // For other numbers, create a random arrangement
        const roomWidth = Math.min(dimensions.width / 2, 3);
        const roomLength = Math.min(dimensions.length / 2, 3);
        const maxRooms = Math.floor((dimensions.width / roomWidth) * (dimensions.length / roomLength));

        for (let i = 0; i < Math.min(numRooms, maxRooms); i++) {
            const x = (Math.random() - 0.5) * (dimensions.width - roomWidth);
            const z = (Math.random() - 0.5) * (dimensions.length - roomLength);

            // For random arrangements, assume all walls are outer walls
            const outerWalls = {
                front: true,
                back: true,
                left: true,
                right: true,
            };

            const room: Room = {
                position: [x, yOffset + roomHeight / 2, z],
                dimensions: [roomWidth, roomHeight, roomLength],
                outerWalls,
                windows: calculateWindowPositions([roomWidth, roomHeight, roomLength], outerWalls),
                story: storyIndex
            };
            rooms.push(room);
        }
    }

    return rooms;
} 