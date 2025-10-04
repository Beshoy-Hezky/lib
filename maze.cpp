#include <algorithm>
#include <chrono>
#include <cmath>
#include <iostream>
#include <limits>
#include <optional>
#include <queue>
#include <random>
#include <stack>
#include <string>
#include <thread>
#include <utility>
#include <vector>

namespace
{

struct Point
{
    int r = 0;
    int c = 0;
};

bool operator==(const Point &lhs, const Point &rhs)
{
    return lhs.r == rhs.r && lhs.c == rhs.c;
}

bool operator!=(const Point &lhs, const Point &rhs)
{
    return !(lhs == rhs);
}

enum class Direction
{
    Up = 0,
    Right = 1,
    Down = 2,
    Left = 3
};

constexpr int dr[] = {-1, 0, 1, 0};
constexpr int dc[] = {0, 1, 0, -1};

Direction opposite(Direction d)
{
    return static_cast<Direction>((static_cast<int>(d) + 2) % 4);
}

struct Cell
{
    bool walls[4] = {true, true, true, true};
    bool carved = false;
};

class Maze
{
  public:
    Maze(int rows, int cols, std::optional<unsigned int> seed = std::nullopt)
        : rows_(rows), cols_(cols), grid_(rows, std::vector<Cell>(cols))
    {
        generate(seed);
    }

    int rows() const noexcept { return rows_; }
    int cols() const noexcept { return cols_; }

    bool canMove(const Point &from, Direction dir) const
    {
        return !grid_.at(from.r).at(from.c).walls[static_cast<int>(dir)];
    }

    std::vector<Point> neighbours(const Point &p) const
    {
        std::vector<Point> result;
        for (int i = 0; i < 4; ++i)
        {
            auto dir = static_cast<Direction>(i);
            if (!canMove(p, dir))
            {
                continue;
            }
            int nr = p.r + dr[i];
            int nc = p.c + dc[i];
            if (nr >= 0 && nr < rows_ && nc >= 0 && nc < cols_)
            {
                result.push_back(Point{nr, nc});
            }
        }
        return result;
    }

  private:
    int rows_;
    int cols_;
    std::vector<std::vector<Cell>> grid_;

    void generate(std::optional<unsigned int> seed)
    {
        std::mt19937 rng(seed.value_or(std::random_device{}()));

        std::stack<Point> stack;
        Point start{0, 0};
        grid_[start.r][start.c].carved = true;
        stack.push(start);
        int carved = 1;
        int total = rows_ * cols_;

        while (!stack.empty())
        {
            Point current = stack.top();
            std::vector<Direction> options;
            options.reserve(4);
            for (int i = 0; i < 4; ++i)
            {
                int nr = current.r + dr[i];
                int nc = current.c + dc[i];
                if (nr < 0 || nr >= rows_ || nc < 0 || nc >= cols_)
                {
                    continue;
                }
                if (!grid_[nr][nc].carved)
                {
                    options.push_back(static_cast<Direction>(i));
                }
            }

            if (options.empty())
            {
                stack.pop();
                continue;
            }

            std::uniform_int_distribution<int> dist(0, static_cast<int>(options.size()) - 1);
            Direction dir = options[dist(rng)];
            int idx = static_cast<int>(dir);
            int nr = current.r + dr[idx];
            int nc = current.c + dc[idx];

            grid_[current.r][current.c].walls[idx] = false;
            grid_[nr][nc].walls[static_cast<int>(opposite(dir))] = false;
            grid_[nr][nc].carved = true;

            stack.push(Point{nr, nc});
            ++carved;

            if (carved >= total)
            {
                break;
            }
        }
    }
};

enum class TileState
{
    Unvisited,
    Frontier,
    Visited,
    Path,
    Start,
    Goal
};

class Renderer
{
  public:
    void render(const Maze &maze, const std::vector<std::vector<TileState>> &states, const std::string &title,
                int step) const
    {
        const int rows = maze.rows();
        const int cols = maze.cols();
        std::cout << "\x1b[?25l"; // hide cursor
        std::cout << "\x1b[H";    // move to top left
        std::cout << title << " — step " << step << "\n";
        drawBorder(cols, 'T');
        for (int r = 0; r < rows; ++r)
        {
            std::cout << "│";
            for (int c = 0; c < cols; ++c)
            {
                std::cout << colouredCell(states[r][c]) << "│";
            }
            std::cout << '\n';
            if (r + 1 < rows)
            {
                drawBorder(cols, 'M');
            }
        }
        drawBorder(cols, 'B');
        std::cout << std::flush;
    }

    void finish() const
    {
        std::cout << "\x1b[?25h" << std::flush;
    }

  private:
    static std::string colouredCell(TileState state)
    {
        switch (state)
        {
        case TileState::Start:
            return "\x1b[48;5;51m  \x1b[0m";
        case TileState::Goal:
            return "\x1b[48;5;196m  \x1b[0m";
        case TileState::Path:
            return "\x1b[48;5;46m  \x1b[0m";
        case TileState::Frontier:
            return "\x1b[48;5;39m  \x1b[0m";
        case TileState::Visited:
            return "\x1b[48;5;118m  \x1b[0m";
        case TileState::Unvisited:
        default:
            return "\x1b[48;5;255m  \x1b[0m";
        }
    }

    static void drawBorder(int cols, char variant)
    {
        const char *left = nullptr;
        const char *mid = nullptr;
        const char *junction = nullptr;
        const char *right = nullptr;
        switch (variant)
        {
        case 'T':
            left = "┌";
            mid = "──";
            junction = "┬";
            right = "┐";
            break;
        case 'M':
            left = "├";
            mid = "──";
            junction = "┼";
            right = "┤";
            break;
        case 'B':
        default:
            left = "└";
            mid = "──";
            junction = "┴";
            right = "┘";
            break;
        }

        std::cout << left;
        for (int c = 0; c < cols; ++c)
        {
            std::cout << mid;
            if (c + 1 < cols)
            {
                std::cout << junction;
            }
        }
        std::cout << right << '\n';
    }
};

using StateGrid = std::vector<std::vector<TileState>>;
using ParentGrid = std::vector<std::vector<std::optional<Point>>>;

void renderWithDelay(const Renderer &renderer, const Maze &maze, const StateGrid &states, const std::string &title,
                     int &step, int delay_ms)
{
    renderer.render(maze, states, title, step);
    ++step;
    if (delay_ms > 0)
    {
        std::this_thread::sleep_for(std::chrono::milliseconds(delay_ms));
    }
}

void paintPath(StateGrid &states, const ParentGrid &parent, const Point &goal, const Point &start)
{
    Point current = goal;
    while (current != start)
    {
        if (current == goal)
        {
            current = parent[current.r][current.c].value_or(start);
            continue;
        }
        if (current != start)
        {
            states[current.r][current.c] = TileState::Path;
        }
        current = parent[current.r][current.c].value_or(start);
    }
}

void solveDepthFirst(const Maze &maze, Renderer &renderer, StateGrid &states, int delay_ms)
{
    const Point start{0, 0};
    const Point goal{maze.rows() - 1, maze.cols() - 1};
    std::stack<Point> stack;
    stack.push(start);
    ParentGrid parent(maze.rows(), std::vector<std::optional<Point>>(maze.cols()));
    std::vector<std::vector<bool>> seen(maze.rows(), std::vector<bool>(maze.cols(), false));
    seen[start.r][start.c] = true;

    int step = 0;
    renderWithDelay(renderer, maze, states, "Depth-first search", step, delay_ms);

    bool found = false;
    while (!stack.empty())
    {
        Point current = stack.top();
        stack.pop();

        if (current != start && current != goal)
        {
            states[current.r][current.c] = TileState::Visited;
            renderWithDelay(renderer, maze, states, "Depth-first search", step, delay_ms);
        }

        if (current == goal)
        {
            found = true;
            break;
        }

        auto neighbours = maze.neighbours(current);
        for (const Point &next : neighbours)
        {
            if (!seen[next.r][next.c])
            {
                seen[next.r][next.c] = true;
                parent[next.r][next.c] = current;
                stack.push(next);
                if (next != goal)
                {
                    states[next.r][next.c] = TileState::Frontier;
                }
                renderWithDelay(renderer, maze, states, "Depth-first search", step, delay_ms);
            }
        }
    }

    if (found)
    {
        paintPath(states, parent, goal, start);
        renderWithDelay(renderer, maze, states, "Depth-first search — path", step, delay_ms);
    }
}

void solveBreadthFirst(const Maze &maze, Renderer &renderer, StateGrid &states, int delay_ms)
{
    const Point start{0, 0};
    const Point goal{maze.rows() - 1, maze.cols() - 1};
    std::queue<Point> queue;
    queue.push(start);
    ParentGrid parent(maze.rows(), std::vector<std::optional<Point>>(maze.cols()));
    std::vector<std::vector<bool>> seen(maze.rows(), std::vector<bool>(maze.cols(), false));
    seen[start.r][start.c] = true;

    int step = 0;
    renderWithDelay(renderer, maze, states, "Breadth-first search", step, delay_ms);

    bool found = false;
    while (!queue.empty())
    {
        Point current = queue.front();
        queue.pop();

        if (current != start && current != goal)
        {
            states[current.r][current.c] = TileState::Visited;
            renderWithDelay(renderer, maze, states, "Breadth-first search", step, delay_ms);
        }

        if (current == goal)
        {
            found = true;
            break;
        }

        for (const Point &next : maze.neighbours(current))
        {
            if (!seen[next.r][next.c])
            {
                seen[next.r][next.c] = true;
                parent[next.r][next.c] = current;
                queue.push(next);
                if (next != goal)
                {
                    states[next.r][next.c] = TileState::Frontier;
                }
                renderWithDelay(renderer, maze, states, "Breadth-first search", step, delay_ms);
            }
        }
    }

    if (found)
    {
        paintPath(states, parent, goal, start);
        renderWithDelay(renderer, maze, states, "Breadth-first search — path", step, delay_ms);
    }
}

struct AStarNode
{
    Point p;
    int g = 0;
    int h = 0;
};

struct NodeCompare
{
    bool operator()(const AStarNode &a, const AStarNode &b) const noexcept
    {
        const int fa = a.g + a.h;
        const int fb = b.g + b.h;
        if (fa != fb)
        {
            return fa > fb;
        }
        if (a.h != b.h)
        {
            return a.h > b.h;
        }
        return a.g > b.g;
    }
};

int heuristic(const Point &a, const Point &b)
{
    return std::abs(a.r - b.r) + std::abs(a.c - b.c);
}

void solveAStar(const Maze &maze, Renderer &renderer, StateGrid &states, int delay_ms)
{
    const Point start{0, 0};
    const Point goal{maze.rows() - 1, maze.cols() - 1};

    std::priority_queue<AStarNode, std::vector<AStarNode>, NodeCompare> open;
    open.push({start, 0, heuristic(start, goal)});

    ParentGrid parent(maze.rows(), std::vector<std::optional<Point>>(maze.cols()));
    std::vector<std::vector<int>> gScore(maze.rows(), std::vector<int>(maze.cols(), std::numeric_limits<int>::max()));
    gScore[start.r][start.c] = 0;

    int step = 0;
    renderWithDelay(renderer, maze, states, "A* search", step, delay_ms);

    bool found = false;
    while (!open.empty())
    {
        AStarNode node = open.top();
        open.pop();

        if (node.g != gScore[node.p.r][node.p.c])
        {
            continue;
        }

        if (node.p != start && node.p != goal)
        {
            states[node.p.r][node.p.c] = TileState::Visited;
            renderWithDelay(renderer, maze, states, "A* search", step, delay_ms);
        }

        if (node.p == goal)
        {
            found = true;
            break;
        }

        for (const Point &next : maze.neighbours(node.p))
        {
            int tentative = gScore[node.p.r][node.p.c] + 1;
            if (tentative < gScore[next.r][next.c])
            {
                parent[next.r][next.c] = node.p;
                gScore[next.r][next.c] = tentative;
                int hScore = heuristic(next, goal);
                open.push({next, tentative, hScore});
                if (next != goal)
                {
                    states[next.r][next.c] = TileState::Frontier;
                }
                renderWithDelay(renderer, maze, states, "A* search", step, delay_ms);
            }
        }
    }

    if (found)
    {
        for (auto &row : states)
        {
            for (TileState &cell : row)
            {
                if (cell == TileState::Frontier)
                {
                    cell = TileState::Visited;
                }
            }
        }

        paintPath(states, parent, goal, start);
        renderWithDelay(renderer, maze, states, "A* search — path", step, delay_ms);
    }
}

} // namespace

int main()
{
    std::cout << "Maze generator & solver (DFS / BFS / A*)\n";
    std::cout << "------------------------------------------------\n";

    auto parseOrDefault = [](const std::string &text, int fallback, int min, int max) {
        if (text.empty())
        {
            return fallback;
        }
        try
        {
            int value = std::stoi(text);
            return std::clamp(value, min, max);
        }
        catch (...)
        {
            return fallback;
        }
    };

    int rows = 20;
    int cols = 20;
    std::cout << "Enter number of rows (5-40) [20]: ";
    std::string input;
    std::getline(std::cin, input);
    rows = parseOrDefault(input, rows, 5, 40);

    std::cout << "Enter number of columns (5-40) [20]: ";
    std::getline(std::cin, input);
    cols = parseOrDefault(input, cols, 5, 40);

    int delay_ms = 75;
    std::cout << "Delay between frames in ms (10-500) [75]: ";
    std::getline(std::cin, input);
    delay_ms = parseOrDefault(input, delay_ms, 10, 500);

    std::cout << "Choose solver:\n";
    std::cout << "  1. Depth-first search (DFS)\n";
    std::cout << "  2. Breadth-first search (BFS)\n";
    std::cout << "  3. A* search\n";
    int choice = 2;
    std::cout << "Selection [2]: ";
    std::getline(std::cin, input);
    choice = parseOrDefault(input, choice, 1, 3);

    Maze maze(rows, cols);
    StateGrid states(rows, std::vector<TileState>(cols, TileState::Unvisited));
    states.front().front() = TileState::Start;
    states.back().back() = TileState::Goal;

    Renderer renderer;
    std::cout << "\x1b[2J"; // clear screen

    switch (choice)
    {
    case 1:
        solveDepthFirst(maze, renderer, states, delay_ms);
        break;
    case 2:
        solveBreadthFirst(maze, renderer, states, delay_ms);
        break;
    case 3:
    default:
        solveAStar(maze, renderer, states, delay_ms);
        break;
    }

    renderer.finish();
    std::cout << "\nDone! Press Enter to exit.";
    std::getline(std::cin, input);
    return 0;
}

