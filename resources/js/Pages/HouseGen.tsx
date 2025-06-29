import { Canvas } from '@react-three/fiber';
import { OrbitControls } from '@react-three/drei';
import { Suspense, useState, useMemo } from 'react';
import { calculateRoomLayout, type Room, type HouseDimensions, type Story } from '../utils/roomLayout';
import { createHollowBox } from '../utils/hollowBox';

const Room = ({ position, dimensions, color, windows }: {
    position: [number, number, number];
    dimensions: [number, number, number];
    color: string;
    windows: {
        front?: [number, number, number];
        back?: [number, number, number];
        left?: [number, number, number];
        right?: [number, number, number];
    };
}) => {
    const wallThickness = 0.2; // 20cm wall thickness
    const [width, height, length] = dimensions;

    const hollowBox = createHollowBox({
        width,
        height,
        length,
        wallThickness,
        color,
        windows
    });

    return (
        <primitive object={hollowBox} position={position} />
    );
};

const GroundPlane = ({ dimensions, color }: {
    dimensions: [number, number];
    color: string;
}) => {
    const [width, length] = dimensions;

    return (
        <mesh rotation={[-Math.PI / 2, 0, 0]} position={[0, -0.1, 0]}>
            <planeGeometry args={[width, length]} />
            <meshStandardMaterial color={color} />
        </mesh>
    );
};

const HouseGen = () => {
    const [dimensions, setDimensions] = useState<HouseDimensions>({
        length: 10,
        width: 10,
        height: 3
    });

    const [lotDimensions, setLotDimensions] = useState<[number, number]>([15, 15]);
    const [stories, setStories] = useState<Story[]>([
        { numRooms: 4, height: 3 }
    ]);
    const [wallColor, setWallColor] = useState('#D2D8E4');
    const [groundColor, setGroundColor] = useState('#8FBC8F');

    const defaultDimensions: HouseDimensions = {
        length: 10,
        width: 10,
        height: 3
    };

    const defaultLotDimensions: [number, number] = [15, 15];
    const defaultStories: Story[] = [{ numRooms: 4, height: 3 }];

    const handleDimensionChange = (dimension: 'length' | 'width' | 'height', value: number) => {
        setDimensions(prev => ({
            ...prev,
            [dimension]: value
        }));
    };

    const handleLotDimensionChange = (dimension: 'width' | 'length', value: number) => {
        setLotDimensions(prev => {
            if (dimension === 'width') {
                return [value, prev[1]];
            } else {
                return [prev[0], value];
            }
        });
    };

    const handleStoryChange = (storyIndex: number, field: 'numRooms' | 'height', value: number) => {
        setStories(prev => prev.map((story, index) =>
            index === storyIndex
                ? { ...story, [field]: value }
                : story
        ));
    };

    const addStory = () => {
        setStories(prev => [...prev, { numRooms: 2, height: 3 }]);
    };

    const removeStory = (storyIndex: number) => {
        if (stories.length > 1) {
            setStories(prev => prev.filter((_, index) => index !== storyIndex));
        }
    };

    const handleReset = () => {
        setDimensions(defaultDimensions);
        setLotDimensions(defaultLotDimensions);
        setStories(defaultStories);
        setWallColor('#D2D8E4');
        setGroundColor('#8FBC8F');
    };

    // Calculate room layout using the utility function
    const roomLayout = useMemo(() => {
        return calculateRoomLayout(stories, dimensions);
    }, [stories, dimensions]);

    return (
        <div className="w-full h-screen relative">
            {/* Control Panel */}
            <div className="absolute top-4 left-4 bg-white/90 backdrop-blur-sm p-4 rounded-lg shadow-lg z-10 min-w-64 max-h-[90vh] overflow-y-auto">
                <h2 className="text-lg font-semibold mb-4 text-gray-800">House Layout (Meters)</h2>

                <div className="space-y-4">
                    <div className="border-b border-gray-200 pb-3">
                        <h3 className="text-md font-medium text-gray-700 mb-3">House Dimensions</h3>
                        <div>
                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                Length: {dimensions.length}m
                            </label>
                            <input
                                type="range"
                                min="5"
                                max="20"
                                step="0.5"
                                value={dimensions.length}
                                onChange={(e) => handleDimensionChange('length', parseFloat(e.target.value))}
                                className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider"
                            />
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                Width: {dimensions.width}m
                            </label>
                            <input
                                type="range"
                                min="4"
                                max="15"
                                step="0.5"
                                value={dimensions.width}
                                onChange={(e) => handleDimensionChange('width', parseFloat(e.target.value))}
                                className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider"
                            />
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                Height: {dimensions.height}m
                            </label>
                            <input
                                type="range"
                                min="2.5"
                                max="6"
                                step="0.1"
                                value={dimensions.height}
                                onChange={(e) => handleDimensionChange('height', parseFloat(e.target.value))}
                                className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider"
                            />
                        </div>
                    </div>

                    <div className="border-b border-gray-200 pb-3">
                        <h3 className="text-md font-medium text-gray-700 mb-3">Stories ({stories.length})</h3>

                        {stories.map((story, storyIndex) => (
                            <div key={storyIndex} className="mb-4 p-3 bg-gray-50 rounded-lg">
                                <div className="flex items-center justify-between mb-2">
                                    <span className="text-sm font-medium text-gray-700">
                                        Story {storyIndex + 1}
                                    </span>
                                    {stories.length > 1 && (
                                        <button
                                            onClick={() => removeStory(storyIndex)}
                                            className="text-red-500 hover:text-red-700 text-sm"
                                        >
                                            Remove
                                        </button>
                                    )}
                                </div>

                                <div className="space-y-2">
                                    <div>
                                        <label className="block text-xs font-medium text-gray-600 mb-1">
                                            Rooms: {story.numRooms}
                                        </label>
                                        <input
                                            type="range"
                                            min="1"
                                            max="9"
                                            step="1"
                                            value={story.numRooms}
                                            onChange={(e) => handleStoryChange(storyIndex, 'numRooms', parseInt(e.target.value))}
                                            className="w-full h-1.5 bg-gray-200 rounded-lg appearance-none cursor-pointer slider"
                                        />
                                    </div>

                                    <div>
                                        <label className="block text-xs font-medium text-gray-600 mb-1">
                                            Height: {story.height}m
                                        </label>
                                        <input
                                            type="range"
                                            min="2.5"
                                            max="6"
                                            step="0.1"
                                            value={story.height}
                                            onChange={(e) => handleStoryChange(storyIndex, 'height', parseFloat(e.target.value))}
                                            className="w-full h-1.5 bg-gray-200 rounded-lg appearance-none cursor-pointer slider"
                                        />
                                    </div>
                                </div>
                            </div>
                        ))}

                        <button
                            onClick={addStory}
                            className="w-full bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 text-sm"
                        >
                            Add Story
                        </button>
                    </div>

                    <div className="border-b border-gray-200 pb-3">
                        <h3 className="text-md font-medium text-gray-700 mb-3">Lot Area</h3>
                        <div>
                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                Lot Width: {lotDimensions[0]}m
                            </label>
                            <input
                                type="range"
                                min="10"
                                max="30"
                                step="1"
                                value={lotDimensions[0]}
                                onChange={(e) => handleLotDimensionChange('width', parseInt(e.target.value))}
                                className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider"
                            />
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                Lot Length: {lotDimensions[1]}m
                            </label>
                            <input
                                type="range"
                                min="10"
                                max="30"
                                step="1"
                                value={lotDimensions[1]}
                                onChange={(e) => handleLotDimensionChange('length', parseInt(e.target.value))}
                                className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider"
                            />
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                Ground Color
                            </label>
                            <input
                                type="color"
                                value={groundColor}
                                onChange={(e) => setGroundColor(e.target.value)}
                                className="w-full h-10 rounded-lg cursor-pointer"
                            />
                        </div>
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-gray-700 mb-2">
                            Wall Color
                        </label>
                        <input
                            type="color"
                            value={wallColor}
                            onChange={(e) => setWallColor(e.target.value)}
                            className="w-full h-10 rounded-lg cursor-pointer"
                        />
                    </div>

                    <div className="pt-2">
                        <button
                            onClick={handleReset}
                            className="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200"
                        >
                            Reset to Default
                        </button>
                    </div>
                </div>
            </div>

            <Canvas camera={{ position: [15, 15, 15] }}>
                <Suspense fallback={null}>
                    {/* Lighting */}
                    <ambientLight intensity={0.5} />
                    <directionalLight position={[10, 10, 5]} intensity={1} />

                    {/* Ground Plane */}
                    <GroundPlane dimensions={lotDimensions} color={groundColor} />

                    {/* Rooms */}
                    {roomLayout.map((room, index) => (
                        <Room
                            key={index}
                            position={room.position}
                            dimensions={room.dimensions}
                            color={wallColor}
                            windows={room.windows}
                        />
                    ))}

                    {/* Camera Controls */}
                    <OrbitControls />
                </Suspense>
            </Canvas>
        </div>
    );
};

export default HouseGen;